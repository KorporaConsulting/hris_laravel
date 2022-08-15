<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Karyawan;
use App\Models\Kehadiran;
use App\Models\Pengumuman;
use App\Models\Polling;
use Illuminate\Http\Request;
use App\Models\User;
class DashboardController extends Controller
{
    public function user ()
    {

        $user = User::where('users.id', auth()->id())
            ->select('users.name', 'divisi.divisi', 'karyawan.status_pekerja', 'karyawan.no_hp')
            ->leftJoin('karyawan', 'karyawan.user_id', '=', 'users.id')
            ->leftJoin('divisi_user', 'divisi_user.user_id', '=', 'users.id')
            ->leftJoin('divisi', 'divisi.id', '=', 'divisi_user.divisi_id')
            ->first();
            
        $announcements = User::with(['announcements' => function($q){
                $q->with('created_by');
                $q->where('date_start', '<=', date('Y-m-d'));
                $q->where('date_end', '>=', date('Y-m-d'));
            }])
            ->where('id', auth()->id())
            ->first();

        $announcements = $announcements->announcements;

        $pollings = Polling::with(['options', 'created_by', 'answer'])
            ->where('date_start', '<=', date('Y-m-d'))
            ->where('date_end', '>=', date('Y-m-d'))
            ->withCount('answers')
            ->get();


        $presents = Kehadiran::where('user_id', auth()->id())->get();

        // Hitung total kehadiran semua type
        $countAllPresents = $presents->count();
        
        $presents = $presents->groupBy('type');
        
        // Hitung Hadir Saja
        $countPresents = count($presents['hadir'] ?? []);
        
        $events = Event::with('user')->whereDate('start', date("Y-m-d"))->get();

        return view('dashboard.user', 
            compact('user', 'announcements','pollings', 'presents', 'countPresents', 'countAllPresents', 'events'));
    }
}
