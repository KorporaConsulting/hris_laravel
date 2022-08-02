<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{


    public function index ()
    {
        
        return view('kehadiran.index', [
            'presents' => Kehadiran::with('user')->latest()->get()
        ]);
    }

    public function kehadiranStaff (){

            $divisi = DB::table('divisi_user')->where('user_id', auth()->id())->first();

            $presents = Kehadiran::where('divisi_user.status', 'staff')
                ->where('divisi_user.divisi_id', $divisi->divisi_id)
                ->leftJoin('divisi_user', 'kehadiran.user_id', '=', 'divisi_user.user_id')
                ->leftJoin('users', 'divisi_user.user_id', '=', 'users.id')
                ->get();          

            return view('kehadiran.kehadiranStaff', compact('presents'));
    }



    public function kehadiranSaya ()
    {
        $kehadiran = Kehadiran::where('user_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->first();
        return view('kehadiran.kehadiranSaya', compact('kehadiran'));
    }

    public function present (){

        Kehadiran::create([
            'user_id' => auth()->id()
        ]);

        return redirect()->route('kehadiran.kehadiran-saya')->with('success', "Berhasil Absensi");
    }
}
