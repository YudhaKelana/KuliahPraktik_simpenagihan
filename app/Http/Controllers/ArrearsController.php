<?php

namespace App\Http\Controllers;

use App\Models\ArrearsItem;
use Illuminate\Http\Request;

class ArrearsController extends Controller
{
    public function index(Request $request)
    {
        $query = ArrearsItem::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plate_number', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('flag')) {
            if ($request->flag === 'phone_invalid') {
                $query->where('flag_phone_invalid', true);
            } elseif ($request->flag === 'address_suspect') {
                $query->where('flag_address_suspect', true);
            } elseif ($request->flag === 'incomplete') {
                $query->where(function ($q) {
                    $q->where('flag_phone_invalid', true)
                      ->orWhere('flag_address_suspect', true)
                      ->orWhereNull('phone')
                      ->orWhere('phone', '');
                });
            }
        }

        $arrears = $query->latest('calculation_date')->paginate(20)->withQueryString();

        return view('monitoring.arrears.index', compact('arrears'));
    }

    public function show(ArrearsItem $arrear)
    {
        $arrear->load('tasks.employee', 'tasks.followups', 'tasks.latestVehicleStatus');
        return view('monitoring.arrears.show', compact('arrear'));
    }
}
