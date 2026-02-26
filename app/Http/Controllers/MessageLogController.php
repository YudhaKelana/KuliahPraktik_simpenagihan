<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\MessageLog;
use App\Jobs\SendWhatsappMessage;
use Illuminate\Http\Request;

class MessageLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MessageLog::with('reminderItem.vehicle.taxpayer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $query->where('phone', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(20)->withQueryString();
        return view('reminder.logs.index', compact('logs'));
    }

    public function retry(MessageLog $messageLog)
    {
        if ($messageLog->status !== 'failed') {
            return back()->with('error', 'Hanya pesan yang gagal yang bisa di-retry.');
        }

        $messageLog->update([
            'status' => 'queued',
            'retry_count' => $messageLog->retry_count + 1,
            'error_message' => null,
        ]);

        SendWhatsappMessage::dispatch($messageLog);

        AuditTrail::log('retry_send', $messageLog, null, null, "Retry pengiriman pesan #{$messageLog->id}");

        return back()->with('success', 'Pesan dijadwalkan ulang untuk dikirim.');
    }
}
