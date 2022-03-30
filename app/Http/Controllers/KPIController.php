<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KPI;
use App\Models\User;

class KPIController extends Controller
{
    public function index ()
    {
        return view('kpi.index', [
            'users' => User::get()
        ]);
    }

    public function show ($userId)
    {
        return view('kpi.show', [
            'kpi' => KPI::where('user_id', $userId)->whereYear('created_at', date('Y'))->orderBy('bulan')->take(12)->get()
        ]);
    }
    
    public function myKPI ()
    {
        return view('kpi.show', [
            'kpi' => KPI::where('user_id', auth()->id())->whereYear('created_at', date('Y'))->orderBy('bulan')->take(12)->get()
        ]);
    }

    public function store ()
    {
        $date = date_create(request('month'));

        KPI::create([
            'user_id' => request('user_id'),
            'point' => request('point'),
            'bulan' => date_format($date, 'Y-m-d')
        ]);

        session()->flash('success', "Berhasil menambahkan KPI");

        return response()->json([
            'success' => true
        ]);
    }
}
