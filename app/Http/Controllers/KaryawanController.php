<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index (){
        
        return view('karyawan.index', [
            'users' => User::with('karyawan')->get()
        ]);
    }

    public function show ($userId)
    {
        return view('karyawan.show', [
            'user' => User::with(['karyawan', 'kpi'])->where('id', $userId)->get()
        ]);
    }

    public function edit($userId)
    {
        $user = User::where('users.id', $userId)
            ->leftJoin('karyawan', 'karyawan.user_id', '=', 'users.id')
            ->leftJoin('divisi_user', 'divisi_user.user_id', '=', 'users.id')
            ->leftJoin('divisi', 'divisi_user.divisi_id', '=', 'divisi.id')
            ->first();
        // return $user;

        // $divisi = DB::table('divisi_user')->where('divisi_user.user_id', $userId)->first();

        $divisi = DB::table('divisi')->get();

        return view('karyawan.edit', compact('user', 'divisi'));
    }
}
