<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleDueController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('taxpayer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhereHas('taxpayer', fn($tq) => $tq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status_payment')) {
            $query->where('status_payment', $request->status_payment);
        }

        if ($request->filled('due_from')) {
            $query->whereDate('due_date', '>=', $request->due_from);
        }
        if ($request->filled('due_to')) {
            $query->whereDate('due_date', '<=', $request->due_to);
        }

        $vehicles = $query->orderBy('due_date')->paginate(20)->withQueryString();
        return view('reminder.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['taxpayer', 'reminderItems.rule', 'reminderItems.batch']);
        return view('reminder.vehicles.show', compact('vehicle'));
    }
}
