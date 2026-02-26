<?php

namespace App\Http\Controllers;

use App\Models\ArrearsItem;
use App\Models\Employee;
use App\Models\Followup;
use App\Models\MessageLog;
use App\Models\ReminderBatch;
use App\Models\Task;
use App\Models\VehicleStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Cards
        $totalArrears = ArrearsItem::count();
        $totalArrearAmount = ArrearsItem::sum('arrears_amount');
        $totalTasks = Task::count();
        $tasksByStatus = Task::selectRaw("status, count(*) as total")->groupBy('status')->pluck('total', 'status');
        $totalFollowups = Followup::count();
        $todayFollowups = Followup::whereDate('followup_date', today())->count();

        // Overdue tasks (warning + critical)
        $warningDays = config('samsat.overdue_warning_days', 7);
        $criticalDays = config('samsat.overdue_critical_days', 14);

        $overdueTasks = Task::where('status', '!=', 'done')
            ->whereDate('assigned_date', '<=', now()->subDays($warningDays))
            ->whereDoesntHave('followups')
            ->with(['arrearsItem', 'employee'])
            ->orderBy('assigned_date')
            ->limit(10)
            ->get();

        // Missing status (has followup but no vehicle status)
        $missingStatus = Task::where('status', '!=', 'done')
            ->whereHas('followups')
            ->whereDoesntHave('vehicleStatuses')
            ->with(['arrearsItem', 'employee'])
            ->limit(10)
            ->get();

        // Incomplete data
        $incompleteData = ArrearsItem::where(function ($q) {
            $q->where('flag_phone_invalid', true)
              ->orWhere('flag_address_suspect', true)
              ->orWhereNull('phone')
              ->orWhere('phone', '');
        })->count();

        // Vehicle status distribution
        $statusDistribution = VehicleStatus::selectRaw("status, count(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status');

        // Follow-up trend (last 7 days)
        $followupTrend = Followup::selectRaw("DATE(followup_date) as date, type, count(*) as total")
            ->where('followup_date', '>=', now()->subDays(7))
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get();

        // Reminder stats
        $reminderStats = [
            'total_batches' => ReminderBatch::count(),
            'pending' => ReminderBatch::where('status', 'pending_approval')->count(),
            'sent_today' => MessageLog::whereDate('sent_at', today())->where('status', 'sent')->count(),
            'failed_today' => MessageLog::whereDate('created_at', today())->where('status', 'failed')->count(),
        ];

        // Employee workload
        $employeeWorkload = Employee::withCount(['activeTasks', 'followups' => function ($q) {
            $q->whereDate('followup_date', '>=', now()->subDays(7));
        }])->where('is_active', true)->get();

        return view('dashboard.index', compact(
            'totalArrears',
            'totalArrearAmount',
            'totalTasks',
            'tasksByStatus',
            'totalFollowups',
            'todayFollowups',
            'overdueTasks',
            'missingStatus',
            'incompleteData',
            'statusDistribution',
            'followupTrend',
            'reminderStats',
            'employeeWorkload',
            'warningDays',
            'criticalDays'
        ));
    }
}
