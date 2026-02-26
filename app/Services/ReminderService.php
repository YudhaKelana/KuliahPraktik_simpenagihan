<?php

namespace App\Services;

use App\Jobs\SendWhatsappMessage;
use App\Models\MessageLog;
use App\Models\ReminderBatch;
use App\Models\ReminderItem;
use App\Models\ReminderRule;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReminderService
{
    public function generateBatch(
        int $userId,
        int $ruleId,
        string $dueDateFrom,
        string $dueDateTo,
        ?string $filterDescription = null,
    ): ReminderBatch {
        $rule = ReminderRule::findOrFail($ruleId);

        $batch = ReminderBatch::create([
            'created_by' => $userId,
            'status' => 'draft',
            'filter_description' => $filterDescription ?? "Rule: {$rule->name}, Jatuh tempo: {$dueDateFrom} s/d {$dueDateTo}",
        ]);

        // Get vehicles with due dates in range
        $vehicles = Vehicle::with('taxpayer')
            ->where('status_payment', 'unpaid')
            ->whereBetween('due_date', [$dueDateFrom, $dueDateTo])
            ->get();

        $itemCount = 0;
        $skippedCount = 0;

        foreach ($vehicles as $vehicle) {
            $taxpayer = $vehicle->taxpayer;

            // Skip conditions
            if (!$taxpayer) {
                continue;
            }

            $skipReason = null;

            if ($taxpayer->opt_out) {
                $skipReason = 'opt_out';
            } elseif (empty($taxpayer->phone_e164) || $taxpayer->flag_phone_invalid) {
                $skipReason = 'phone_invalid';
            } elseif ($vehicle->status_payment === 'paid') {
                $skipReason = 'already_paid';
            }

            // Check for duplicate
            $plannedAt = Carbon::parse($vehicle->due_date)->subDays($rule->days_before_due)
                ->setTimeFromTimeString($rule->send_window_start);

            $exists = ReminderItem::where('vehicle_id', $vehicle->id)
                ->where('reminder_rule_id', $rule->id)
                ->whereDate('planned_send_at', $plannedAt->toDateString())
                ->exists();

            if ($exists) {
                $skipReason = $skipReason ?? 'duplicate';
            }

            $item = ReminderItem::create([
                'reminder_batch_id' => $batch->id,
                'vehicle_id' => $vehicle->id,
                'reminder_rule_id' => $rule->id,
                'taxpayer_id' => $taxpayer->id,
                'planned_send_at' => $plannedAt,
                'status' => $skipReason ? 'skipped' : 'pending',
                'skip_reason' => $skipReason,
            ]);

            if ($skipReason) {
                $skippedCount++;
            } else {
                $itemCount++;
            }
        }

        $batch->update([
            'total_items' => $itemCount + $skippedCount,
            'skipped_count' => $skippedCount,
        ]);

        return $batch;
    }

    public function scheduleBatch(ReminderBatch $batch): void
    {
        $batch->update([
            'status' => 'scheduled',
            'scheduled_at' => now(),
        ]);

        // Dispatch jobs for all pending items
        $items = $batch->items()->where('status', 'pending')->get();

        foreach ($items as $item) {
            $this->dispatchItem($item);
        }

        $batch->update(['status' => 'processing']);
    }

    public function dispatchItem(ReminderItem $item): void
    {
        $item->update(['status' => 'queued']);

        // Build message from template
        $rule = $item->rule;
        $vehicle = $item->vehicle;
        $taxpayer = $item->taxpayer;

        $messageBody = str_replace(
            ['{nama}', '{nopol}', '{tanggal_jatuh_tempo}'],
            [$taxpayer->name, $vehicle->plate_number, $vehicle->due_date?->format('d/m/Y')],
            $rule->template_text ?? 'Pengingat pajak kendaraan {nopol}'
        );

        // Create message log
        $log = MessageLog::create([
            'reminder_item_id' => $item->id,
            'provider' => config('samsat.wa.provider'),
            'phone' => $taxpayer->phone_e164,
            'message_body' => $messageBody,
            'status' => 'queued',
        ]);

        // Dispatch job
        SendWhatsappMessage::dispatch($log)
            ->delay($item->planned_send_at > now() ? $item->planned_send_at : null);
    }
}
