<?php

namespace App\Http\Controllers;

use App\Models\SpsopkbLetter;
use App\Models\Task;
use Illuminate\Http\Request;

class SpsopkbController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        // Candidates: follow-up >= 2 AND age >= 14 days AND not done AND no SPSOPKB yet
        $candidatesQuery = Task::where('status', '!=', 'done')
            ->whereDoesntHave('spsopkbLetter')
            ->withCount('followups')
            ->having('followups_count', '>=', config('samsat.spsopkb_min_followups', 2))
            ->whereDate('assigned_date', '<=', now()->subDays(config('samsat.spsopkb_min_age_days', 14)))
            ->with(['arrearsItem', 'employee']);

        if ($search) {
            $candidatesQuery->whereHas('arrearsItem', function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        $candidates = $candidatesQuery->paginate($perPage, ['*'], 'candidates_page')->withQueryString();

        // Issued letters
        $lettersQuery = SpsopkbLetter::with(['task.arrearsItem', 'task.employee'])
            ->latest('issued_date');

        if ($search) {
            $lettersQuery->whereHas('task.arrearsItem', function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        $letters = $lettersQuery->paginate($perPage, ['*'], 'letters_page')->withQueryString();

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
