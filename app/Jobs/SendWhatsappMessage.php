<?php

namespace App\Jobs;

use App\Models\MessageLog;
use App\Models\ReminderBatch;
use App\Models\ReminderItem;
use App\Services\WhatsappProviderClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public array $backoff = [30, 60, 120, 300, 600];

    public function __construct(
        public MessageLog $messageLog
    ) {}

    public function handle(): void
    {
        $log = $this->messageLog;

        try {
            $client = new WhatsappProviderClient();
            $result = $client->send(
                phone: $log->phone,
                message: $log->message_body,
            );

            $log->update([
                'status' => 'sent',
                'provider_message_id' => $result['message_id'] ?? null,
                'sent_at' => now(),
            ]);

            // Update reminder item status
            if ($log->reminderItem) {
                $log->reminderItem->update(['status' => 'sent']);
                $this->updateBatchProgress($log->reminderItem);
            }
        } catch (\Exception $e) {
            Log::error("WA Send Failed: {$e->getMessage()}", [
                'message_log_id' => $log->id,
                'phone' => $log->phone,
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
                    $this->delete(); // Don't retry permanent errors
                    return;
                }
            }

            throw $e; // Let the queue retry
        }
    }

    private function isPermanentError(\Exception $e): bool
    {
        $message = strtolower($e->getMessage());
        $permanentKeywords = ['invalid number', 'not registered', 'blocked', 'invalid phone', 'nomor tidak valid'];

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
