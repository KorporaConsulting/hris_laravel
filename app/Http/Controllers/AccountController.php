<?php

namespace App\Http\Controllers;

use App\Models\{Karyawan, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index ()
    {
        return view('account.index', [
            'user' => Karyawan::where('user_id', auth()->id())->first()
        ]);
    }

    public function edit ()
    {
        return view('account.edit', [
            'user' => Karyawan::where('user_id', auth()->id())->first(),
        ]);
    }

    public function update()
    {
        if(request()->has('profile')){
            $profile = request('profile')->store('profiles');
        }else{
            $profile = auth()->user()->img;
        }

        User::where('id', auth()->id())->update([
            'name' => request('name'),
            'email' => request('email'),
            'divisi' => request('divisi'),
            'img' => $profile
        ]);
        
        Karyawan::where('user_id', auth()->id())->update([
            'jabatan' => request('jabatan'),
            'alamat_ktp' => request('alamat_ktp'),
            'alamat_domisili' => request('alamat_domisili'),
            'no_hp' => request('no_hp'),
            'no_hp_darurat' => request('no_hp_darurat'),
            
        ]);

        session()->flash('success', 'Berhasil Mengaupdate data akun');

        return redirect()->route('account.index');
    }

    public function create ()
    {
        return view('account.create',[
            'divisions' => DB::table('divisi')->get(),
            'levels' => DB::table('level')->get(),
            'users' => User::whereIn('level', ['manager', 'direktur'])->get() 
        ]);
    }

    public function store ()
    {

        $user = User::create(request()->only(['name', 'email', 'password', 'divisi', 'level', 'parent_id']));

        Karyawan::create(array_merge(request()->only([
            'jabatan', 'gaji', 'status_user', 'alamat_ktp', 'alamat_domisili', 'mulai_kerja', 'tmpt_lahir', 'tgl_lahir'
        ]), ['user_id' => $user->id]));

        session()->flash('success', 'Berhasil menambahkan Karyawan');

        return back();
    }


}
