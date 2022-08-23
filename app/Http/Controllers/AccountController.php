<?php

namespace App\Http\Controllers;

use App\Models\{Karyawan, User};
use App\Rules\CheckOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index', [
            'user' => Karyawan::where('user_id', auth()->id())->first()
        ]);
    }

    public function edit()
    {
        return view('account.edit', [
            'user' => Karyawan::where('user_id', auth()->id())->first(),
            'divisi' => DB::table('divisi')->get()
        ]);
    }

    public function update()
    {
        if (request()->has('profile')) {
            $profile = request('profile')->store('profiles');
        } else {
            $profile = auth()->user()->img;
        }

        User::where('id', auth()->id())->update([
            'name'      => request('name'),
            'email'     => request('email'),
            'divisi'    => request('divisi'),
            'img'       => $profile
        ]);

        Karyawan::where('user_id', auth()->id())->update(request()->only([
            'jabatan', 'alamat_ktp', 'alamat_domisili', 'no_hp', 'no_hp_darurat'
        ]));

        session()->flash('success', 'Berhasil Mengaupdate data akun');

        return redirect()->route('account.index');
    }

    public function create()
    {

        return view('account.create', [
            'divisions' => DB::table('divisi')->get(),
            'users' => User::get()
        ]);
    }

    public function changePassword ()
    {
        return view('account.changePassword');
    }

    public function updatePassword ()
    {
        request()->validate([
            'oldPassword' => ['required', new CheckOldPassword],
            'newPassword' => ['required', 'confirmed', 'min:8']
        ]);

        User::whereId(auth()->id())->update(['password' => bcrypt(request('newPassword'))]);
        
        return redirect()->route('user.dashboard')->with('success', 'Berhasil mengganti password');
    }

    public function store()
    {

        request()->validate([
            'email' => 'required|unique:users'
        ]);

        $user = [
            'name'          => request('name'),
            'email'         => request('email'),
            'password'      => bcrypt(request('password')),
        ];

        $user = User::create($user);

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
            'user_id'           => $user->id,
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

        if(request('status_pekerja') != 'pekerja tetap'){
            $karyawan['lama_kontrak'] = request('lama_kontrak');
            $add = '+'.request('lama_kontrak')."month";
            $karyawan['habis_kontrak'] = date('Y-m-d', strtotime($add));
        }

        if (!empty(request('divisi'))) {
            $karyawan['divisi_id'] = request('divisi');
        }

        Karyawan::create($karyawan);

        return back()->with('success', 'Berhasil menambahkan Karyawan');
    }
}
