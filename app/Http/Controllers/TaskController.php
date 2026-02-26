<?php

namespace App\Http\Controllers;

use App\Models\ArrearsItem;
use App\Models\AuditTrail;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['arrearsItem', 'employee', 'latestFollowup', 'latestVehicleStatus'])
            ->withCount('followups');

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('assigned_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('assigned_date', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('arrearsItem', function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('flag')) {
            if ($request->flag === 'overdue') {
                $warningDays = config('samsat.overdue_warning_days', 7);
                $query->where('status', '!=', 'done')
                      ->whereDate('assigned_date', '<=', now()->subDays($warningDays))
                      ->whereDoesntHave('followups');
            } elseif ($request->flag === 'missing_status') {
                $query->where('status', '!=', 'done')
                      ->whereHas('followups')
                      ->whereDoesntHave('vehicleStatuses');
            }
        }

        $tasks = $query->latest('assigned_date')->paginate(20)->withQueryString();
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('monitoring.tasks.index', compact('tasks', 'employees'));
    }

    public function create()
    {
        $arrearsItems = ArrearsItem::doesntHave('task')
            ->orderBy('plate_number')
            ->limit(100)
            ->get();
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('monitoring.tasks.create', compact('arrearsItems', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'arrears_item_id' => 'required|exists:arrears_items,id',
            'employee_id' => 'nullable|exists:employees,id',
            'assigned_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:assigned_date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'new';
        $task = Task::create($validated);

        AuditTrail::log('create_task', $task, null, $validated, 'Tugas baru dibuat');

        return redirect()->route('monitoring.tasks.show', $task)->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Task $task)
    {
        $task->load([
            'arrearsItem',
            'employee',
            'followups.employee',
            'vehicleStatuses.reporter',
            'spsopkbLetter',
        ]);
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('monitoring.tasks.show', compact('task', 'employees'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::where('is_active', true)->orderBy('name')->get();
        return view('monitoring.tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'status' => 'required|in:new,in_progress,done',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $old = $task->only(['employee_id', 'status', 'due_date', 'notes']);

        if ($validated['status'] === 'done' && $task->status !== 'done') {
            $validated['completed_date'] = now()->toDateString();
        }

        $task->update($validated);

        AuditTrail::log('update_task', $task, $old, $validated, 'Tugas diperbarui');

        return redirect()->route('monitoring.tasks.show', $task)->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        AuditTrail::log('delete_task', $task, $task->toArray(), null, 'Tugas dihapus');
        $task->delete();
        return redirect()->route('monitoring.tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
