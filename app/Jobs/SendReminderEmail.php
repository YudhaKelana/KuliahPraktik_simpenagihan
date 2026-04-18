<?php

namespace App\Jobs;

use App\Mail\TaxPaymentReminder;
use App\Models\MessageLog;
use App\Models\ReminderBatch;
use App\Models\ReminderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [60, 300, 900];

    public function __construct(
        public MessageLog $messageLog
    ) {}

    public function handle(): void
    {
        $log = $this->messageLog;

        try {
            $item = $log->reminderItem;
            $vehicle = $item?->vehicle;
            $taxpayer = $item?->taxpayer;

            if (!$log->recipient_email) {
                throw new \Exception('Email penerima tidak tersedia.');
            }

            Mail::to($log->recipient_email)->send(new TaxPaymentReminder(
                taxpayerName: $taxpayer?->name ?? 'Wajib Pajak',
                plateNumber: $vehicle?->plate_number ?? '-',
                dueDate: $vehicle?->due_date?->format('d/m/Y') ?? '-',
                arrearAmount: 0,
                vehicleType: $vehicle?->vehicle_type,
            ));

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            // Update reminder item status
            if ($item) {
                $item->update(['status' => 'sent']);
                $this->updateBatchProgress($item);
            }
        } catch (\Exception $e) {
            Log::error("Email Send Failed: {$e->getMessage()}", [
                'message_log_id' => $log->id,
                'email' => $log->recipient_email,
            ]);

            $isPermanent = $this->isPermanentError($e);

            if ($isPermanent || $this->attempts() >= $this->tries) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'retry_count' => $this->attempts(),
                ]);

                if ($log->reminderItem) {
                    $log->reminderItem->update(['status' => 'failed']);
                    $this->updateBatchProgress($log->reminderItem, failed: true);
                }

                if ($isPermanent) {
                    $this->delete();
                    return;
                }
            }

            throw $e;
        }
    }

    private function isPermanentError(\Exception $e): bool
    {
        $message = strtolower($e->getMessage());
        $permanentKeywords = [
            'invalid address',
            'mailbox not found',
            'user unknown',
            'recipient rejected',
            'no such user',
            'does not exist',
        ];

        foreach ($permanentKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }

        return false;
    }

    private function updateBatchProgress(ReminderItem $item, bool $failed = false): void
    {
        $batch = $item->batch;
        if (!$batch) return;

        if ($failed) {
            $batch->increment('failed_count');
        } else {
            $batch->increment('sent_count');
        }

        // Check if batch is complete
        $processed = $batch->sent_count + $batch->failed_count + $batch->skipped_count;
        if ($processed >= $batch->total_items && $batch->status === 'processing') {
            $batch->update([
                'status' => 'done',
                'completed_at' => now(),
            ]);
        }
    }
}
