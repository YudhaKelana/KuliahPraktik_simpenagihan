<?php

namespace App\Http\Controllers;

use App\Models\MessageLog;
use App\Models\Taxpayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function status(Request $request)
    {
        // Verify webhook secret
        $secret = config('samsat.wa.webhook_secret');
        if ($secret && $request->header('X-Webhook-Secret') !== $secret) {
            abort(401);
        }

        $messageId = $request->input('message_id') ?? $request->input('id');
        $status = $request->input('status');

        if (!$messageId || !$status) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        $log = MessageLog::where('provider_message_id', $messageId)->first();
        if (!$log) {
            Log::warning("Webhook: message_id {$messageId} not found");
            return response()->json(['ok' => true]);
        }

        $statusMap = [
            'sent' => 'sent',
            'delivered' => 'delivered',
            'read' => 'read',
            'failed' => 'failed',
        ];

        $mappedStatus = $statusMap[$status] ?? null;
        if ($mappedStatus) {
            $update = ['status' => $mappedStatus];
            if ($mappedStatus === 'delivered') {
                $update['delivered_at'] = now();
            }
            if ($mappedStatus === 'failed') {
                $update['error_message'] = $request->input('error') ?? $request->input('reason');
            }
            $log->update($update);
        }

        return response()->json(['ok' => true]);
    }

    public function inbound(Request $request)
    {
        $phone = $request->input('from') ?? $request->input('phone');
        $body = strtoupper(trim($request->input('body') ?? $request->input('message') ?? ''));

        if (in_array($body, ['STOP', 'BERHENTI'])) {
            $taxpayer = Taxpayer::where('phone_e164', $phone)->first();
            if ($taxpayer) {
                $taxpayer->update([
                    'opt_out' => true,
                    'opt_out_at' => now(),
                ]);
                Log::info("Opt-out: taxpayer {$taxpayer->id} ({$phone})");
            }
        }

        return response()->json(['ok' => true]);
    }
}
