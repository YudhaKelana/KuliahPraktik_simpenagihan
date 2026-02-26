<?php

namespace App\Http\Controllers;

use App\Models\ReminderRule;
use Illuminate\Http\Request;

class ReminderRuleController extends Controller
{
    public function index()
    {
        $rules = ReminderRule::latest()->get();
        return view('reminder.rules.index', compact('rules'));
    }

    public function create()
    {
        $rule = new ReminderRule();
        return view('reminder.rules.create', compact('rule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'days_before_due' => 'required|integer',
            'template_code' => 'required|string|max:50',
            'template_text' => 'required|string|max:1000',
            'send_window_start' => 'required|date_format:H:i',
            'send_window_end' => 'required|date_format:H:i|after:send_window_start',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        ReminderRule::create($validated);

        return redirect()->route('reminder.rules.index')->with('success', 'Aturan reminder berhasil ditambahkan.');
    }

    public function edit(ReminderRule $rule)
    {
        return view('reminder.rules.create', compact('rule'));
    }

    public function update(Request $request, ReminderRule $rule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'days_before_due' => 'required|integer',
            'template_code' => 'required|string|max:50',
            'template_text' => 'required|string|max:1000',
            'send_window_start' => 'required|date_format:H:i',
            'send_window_end' => 'required|date_format:H:i|after:send_window_start',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $rule->update($validated);

        return redirect()->route('reminder.rules.index')->with('success', 'Aturan reminder berhasil diperbarui.');
    }

    public function destroy(ReminderRule $rule)
    {
        $rule->delete();
        return redirect()->route('reminder.rules.index')->with('success', 'Aturan reminder berhasil dihapus.');
    }
}
