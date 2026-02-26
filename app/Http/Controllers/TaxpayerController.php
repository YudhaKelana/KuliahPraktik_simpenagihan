<?php

namespace App\Http\Controllers;

use App\Models\Taxpayer;
use Illuminate\Http\Request;

class TaxpayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Taxpayer::withCount('vehicles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone_e164', 'like', "%{$search}%");
            });
        }

        if ($request->filled('opt_out')) {
            $query->where('opt_out', $request->opt_out === 'yes');
        }

        $taxpayers = $query->latest()->paginate(20)->withQueryString();
        return view('reminder.taxpayers.index', compact('taxpayers'));
    }

    public function show(Taxpayer $taxpayer)
    {
        $taxpayer->load('vehicles.reminderItems.batch');
        return view('reminder.taxpayers.show', compact('taxpayer'));
    }

    public function edit(Taxpayer $taxpayer)
    {
        return view('reminder.taxpayers.edit', compact('taxpayer'));
    }

    public function update(Request $request, Taxpayer $taxpayer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_e164' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $taxpayer->update($validated);
        return redirect()->route('reminder.taxpayers.show', $taxpayer)->with('success', 'Data wajib pajak diperbarui.');
    }

    public function toggleOptOut(Taxpayer $taxpayer)
    {
        $taxpayer->update([
            'opt_out' => !$taxpayer->opt_out,
            'opt_out_at' => !$taxpayer->opt_out ? now() : null,
        ]);

        $status = $taxpayer->opt_out ? 'di-opt-out' : 'opt-out dicabut';
        return back()->with('success', "Wajib pajak berhasil {$status}.");
    }
}
