<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Followup;
use App\Models\Task;
use Illuminate\Http\Request;

class EmployeePerformanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::where('is_active', true)
            ->withCount([
                'tasks as total_tasks',
                'activeTasks as active_tasks',
                'tasks as done_tasks' => fn($q) => $q->where('status', 'done'),
                'followups as total_followups',
                'followups as telepon_count' => fn($q) => $q->where('type', 'telepon'),
                'followups as kunjungan_count' => fn($q) => $q->where('type', 'kunjungan'),
            ]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('name')
            ->paginate($request->input('per_page', 20))
            ->withQueryString();

        // Calculate averages for each employee
        $employees->each(function ($emp) {
            $doneTasks = Task::where('employee_id', $emp->id)
                ->where('status', 'done')
                ->whereNotNull('completed_date')
                ->whereNotNull('assigned_date')
                ->get();

            $emp->avg_completion_days = $doneTasks->count() > 0
                ? round($doneTasks->avg(fn($t) => $t->assigned_date->diffInDays($t->completed_date)), 1)
                : 0;

            $emp->tasks_with_status = Task::where('employee_id', $emp->id)
                ->whereHas('vehicleStatuses')
                ->count();

            $emp->status_percentage = $emp->total_tasks > 0
                ? round($emp->tasks_with_status / $emp->total_tasks * 100, 1)
                : 0;
        });

        return view('monitoring.employees.performance', compact('employees'));
    }
}
