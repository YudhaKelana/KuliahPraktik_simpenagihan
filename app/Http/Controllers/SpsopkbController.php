<?php

namespace App\Http\Controllers;

use App\Models\SpsopkbLetter;
use App\Models\Task;
use Illuminate\Http\Request;

class SpsopkbController extends Controller
{
    public function index(Request $request)
    {
        // Candidates: follow-up >= 2 AND age >= 14 days AND not done AND no SPSOPKB yet
        $candidates = Task::where('status', '!=', 'done')
            ->whereDoesntHave('spsopkbLetter')
            ->withCount('followups')
            ->having('followups_count', '>=', config('samsat.spsopkb_min_followups', 2))
            ->whereDate('assigned_date', '<=', now()->subDays(config('samsat.spsopkb_min_age_days', 14)))
            ->with(['arrearsItem', 'employee'])
            ->paginate(20, ['*'], 'candidates_page');

        // Issued letters
        $letters = SpsopkbLetter::with(['task.arrearsItem', 'task.employee'])
            ->latest('issued_date')
            ->paginate(20, ['*'], 'letters_page');

        // Stats
        $totalCandidates = Task::where('status', '!=', 'done')
            ->whereDoesntHave('spsopkbLetter')
            ->withCount('followups')
            ->having('followups_count', '>=', 2)
            ->whereDate('assigned_date', '<=', now()->subDays(14))
            ->count();
        $totalIssued = SpsopkbLetter::where('status', 'terbit')->count();
        $totalTasks = Task::count();
        $ratio = $totalTasks > 0 ? round($totalIssued / $totalTasks * 100, 1) : 0;

        return view('monitoring.spsopkb.index', compact('candidates', 'letters', 'totalCandidates', 'totalIssued', 'ratio'));
    }

    public function promote(Task $task)
    {
        SpsopkbLetter::firstOrCreate(
            ['task_id' => $task->id],
            [
                'status' => 'kandidat',
                'issued_date' => now()->toDateString(),
            ]
        );

        return back()->with('success', 'Tugas dipromosikan sebagai kandidat SPSOPKB.');
    }
}
