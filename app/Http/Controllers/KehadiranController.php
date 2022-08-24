<?php

namespace App\Http\Controllers;

use App\Exports\KehadiranExport;
use App\Models\Kehadiran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class KehadiranController extends Controller
{


    public function index()
    {
        
        if (auth()->user()->hasRole('manager')) {
            $presents = Kehadiran::whereHas('user', function($q){
                $q->where('divisi_id', auth()->user()->divisi_id);
            })
            ->with('user')
            ->latest()
            ->get();

        }else{
            $presents = Kehadiran::whereHas('user')->with('user')->latest()->get();
        }

        return view('kehadiran.index', compact('presents'));
    }

    public function kehadiranSaya()
    {

        $absen = true;
        $message = false;

        $kehadiran = Kehadiran::where('user_id', auth()->id())
            ->whereDate('created_at', date('Y-m-d'))
            ->first();

        if ($kehadiran) {
            $absen = false;
            $message = 'Anda telah absen hari ini pada ' . Carbon::create($kehadiran->created_at)->format('H:i');
        } else {
            if (auth()->user()->wfh_day == Carbon::now('Asia/Jakarta')->format('l')) {
                $absen = false;
                $message = 'Absen otomatis (WFH)';
            } else {
                $response = Http::get('https://kalenderindonesia.com/api/YZ35u6a7sFWN/libur/masehi/' . date('Y/m'));
                $response = json_decode($response, false);
                $holiday = collect($response->data->holiday->data);
                $hasHoliday = $holiday->where('day', date('d'));

                if ($hasHoliday->isNotEmpty() || (strtolower(date('l')) == 'saturday' || strtolower(date('l')) == 'sunday')) {
                    $absen = false;
                    $message = 'Hari libur, tidak bisa absensi';
                }
            }
        }

        return view('kehadiran.kehadiranSaya', compact('kehadiran', 'absen', 'message'));
    }

    public function present()
    {
        $kehadiran = [
            'user_id' => auth()->id(),
        ];

        if(strtotime(date('H:i')) > strtotime('08:00')){
            $kehadiran['type'] = 'telat';
        }else{
            $kehadiran['type'] = 'hadir';
        }

        Kehadiran::create($kehadiran);

        return redirect()->route('kehadiran.kehadiran-saya')->with('success', "Berhasil Absensi");
    }

    public function report ()
    {
        return Excel::download(new KehadiranExport, 'KehadiranReport.xlsx');
    }
}
