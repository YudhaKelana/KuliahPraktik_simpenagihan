<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\ReminderBatch;
use App\Models\ReminderItem;
use App\Models\ReminderRule;
use App\Models\Vehicle;
use App\Services\ReminderService;
use Illuminate\Http\Request;

class ReminderBatchController extends Controller
{
    public function index(Request $request)
    {
        $batches = ReminderBatch::with('creator', 'approver')
            ->latest()
            ->paginate(20);

        return view('reminder.batches.index', compact('batches'));
    }

    public function create()
    {
        $rules = ReminderRule::where('is_active', true)->get();
        return view('reminder.batches.create', compact('rules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reminder_rule_id' => 'required|exists:reminder_rules,id',
            'due_date_from' => 'required|date',
            'due_date_to' => 'required|date|after_or_equal:due_date_from',
            'filter_description' => 'nullable|string|max:500',
        ]);

        $service = new ReminderService();
        $batch = $service->generateBatch(
            auth()->id(),
            $validated['reminder_rule_id'],
            $validated['due_date_from'],
            $validated['due_date_to'],
            $validated['filter_description'] ?? null
        );

        AuditTrail::log('create_batch', $batch, null, $validated, "Batch reminder dibuat: {$batch->total_items} item");

        return redirect()->route('reminder.batches.show', $batch)->with('success', "Batch berhasil dibuat dengan {$batch->total_items} item.");
    }

    public function show(ReminderBatch $batch)
    {
        $batch->load(['creator', 'approver']);
        $items = $batch->items()
            ->with(['vehicle.taxpayer', 'rule'])
            ->paginate(20);

        return view('reminder.batches.show', compact('batch', 'items'));
    }

    public function approve(ReminderBatch $batch)
    {
        if (!in_array($batch->status, ['draft', 'pending_approval'])) {
            return back()->with('error', 'Batch tidak bisa disetujui dengan status saat ini.');
        }

        $batch->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        AuditTrail::log('approve_batch', $batch, null, null, 'Batch disetujui');
        return back()->with('success', 'Batch berhasil disetujui.');
    }

    public function reject(Request $request, ReminderBatch $batch)
    {
        $request->validate(['reject_reason' => 'required|string|max:500']);

        $batch->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

        AuditTrail::log('reject_batch', $batch, null, ['reason' => $request->reject_reason], 'Batch ditolak');
        return back()->with('success', 'Batch berhasil ditolak.');
    }

    public function schedule(ReminderBatch $batch)
    {
        if ($batch->status !== 'approved') {
            return back()->with('error', 'Batch harus disetujui terlebih dahulu.');
        }

        $service = new ReminderService();
        $service->scheduleBatch($batch);

        return back()->with('success', 'Batch berhasil dijadwalkan untuk dikirim.');
    }
}
