<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KPI;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KPIController extends Controller
{
    public function index($userId)
    {
        return view('kpi.index', [
            'user' => User::with(['kpi'])->where('id', $userId)->first()
        ]);
    }

    public function show($userId, $kpiId)
    {
        $where = [
            'users.id' => $userId,
            'kpi.id' => $kpiId
        ];

        $kpi = DB::table('users')
            ->where($where)
            ->leftJoin('kpi', 'kpi.user_id', '=', 'users.id')
            ->first();
        
        return view('kpi.show', compact('kpi'));
    }

    public function create($userId)
    {
        return view('kpi.create', compact('userId'));
    }

    public function myKPI()
    {
        $kpi = KPI::where('user_id', auth()->id())
            ->whereYear('created_at', date('Y'))
            ->orderBy('bulan')
            ->take(12)
            ->get();

        $bulan = $kpi->map(function ($item, $i) {

            $date = date_create($item->bulan);
            return date_format($date, 'F Y');
            
        });

        $point = $kpi->pluck('point');

        return view('kpi.show', compact('bulan', 'point'));
    }

    public function store()
    {
        $data = request()->except(['_token', 'bulan']);
        $data['bulan'] = date_create(request('bulan'));

        KPI::create($data);

        return redirect()->route('karyawan.kpi.index', request('user_id'))->with('success', "Berhasil menambahkan KPI");
    }
}
