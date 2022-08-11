<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

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

    public function csvStore(){

        Excel::import(new UsersImport, request()->file('file')); //only allows for one model
        
        return request()->all();
    }

    public function edit($userId)
    {
        $user = User::where('users.id', $userId)
            ->select('*', 'users.id', 'users.name', 'roles.name as role')
            ->leftJoin('karyawan', 'karyawan.user_id', '=', 'users.id')
            ->leftJoin('divisi_user', 'divisi_user.user_id', '=', 'users.id')
            ->leftJoin('divisi', 'divisi_user.divisi_id', '=', 'divisi.id')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', User::class);
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->first();

        // return $user;
        // return $user;

        // $divisi = DB::table('divisi_user')->where('divisi_user.user_id', $userId)->first();

        $divisi = DB::table('divisi')->get();

        return view('karyawan.edit', compact('user', 'divisi'));
    }

    public function update ($userId)
    {
        // return request()->all();
        $userUpdate = [
            'name'  => request('name'),
            'email' => request('email')
        ];

        $user = User::where('id', $userId)->update($userUpdate);

        if (request('level') == 'manager') {
            $user->assignRole('manager');
        } elseif (request('level') == 'staff') {
            $user->assignRole('staff');
        } elseif (request('level') == 'hrd') {
            $user->assignRole('hrd');
        } elseif (request('level') == 'direktur') {
            $user->assignRole('direktur');
        }

        $karyawan = [
            'nip'               => request('nip'),
            'jabatan'           => request('jabatan'),
            'gaji'              => str_replace(',', '', request('gaji')),
            'status_pekerja'    => request('status_pekerja'),
            'alamat_ktp'        => request('alamat_ktp'),
            'alamat_domisili'   => request('alamat_domisili'),
            'mulai_kerja'       => request('mulai_kerja'),
            'tmpt_lahir'        => request('tmpt_lahir'),
            'tgl_lahir'         => request('tgl_lahir'),
            'sisa_cuti'         => 0,
            'is_active'         => 1,
            'no_hp'             => request('no_hp'),
            'no_hp_darurat'     => request('no_hp_darurat')
        ];

        if (request('status_pekerja') != 'pekerja tetap') {
            $karyawan['lama_kontrak'] = request('lama_kontrak');
            $add = '+' . request('lama_kontrak') . "month";
            $karyawan['habis_kontrak'] = date('Y-m-d', strtotime($add));
        }

        if (!empty(request('divisi'))) {
            $user->divisions()->attach(request('divisi'));
        }

        return back()->with('success', 'Berhasil mengupdate Karyawan');

    }

    public function destroy ($userId)
    {
        
        $user = User::find($userId);
        $user->roles()->detach();
        $user->delete();
        Karyawan::where('user_id', $userId)->delete();
        
        return redirect()->route('karyawan.index')->with('success', 'Berhasil');
        
    }
}
