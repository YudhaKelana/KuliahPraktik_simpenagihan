<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\Task;
use App\Models\VehicleStatus;
use Illuminate\Http\Request;

class VehicleStatusController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(VehicleStatus::STATUSES)),
            'status_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['task_id'] = $task->id;
        $validated['reported_by'] = $task->employee_id;

        $vehicleStatus = VehicleStatus::create($validated);

        AuditTrail::log('create_vehicle_status', $vehicleStatus, null, $validated, "Status kendaraan: {$validated['status']}");

        return back()->with('success', 'Status kendaraan berhasil disimpan.');
    }
}
