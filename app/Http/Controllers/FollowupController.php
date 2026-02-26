<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\Followup;
use App\Models\Task;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'type' => 'required|in:telepon,kunjungan',
            'followup_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'result' => 'nullable|string|max:255',
        ]);

        $validated['task_id'] = $task->id;
        $validated['employee_id'] = $task->employee_id;

        $followup = Followup::create($validated);

        // Auto update task status
        if ($task->status === 'new') {
            $task->update(['status' => 'in_progress']);
        }

        AuditTrail::log('create_followup', $followup, null, $validated, "Follow-up {$validated['type']} pada tugas #{$task->id}");

        return back()->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    public function destroy(Followup $followup)
    {
        AuditTrail::log('delete_followup', $followup, $followup->toArray(), null, 'Follow-up dihapus');
        $followup->delete();
        return back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
