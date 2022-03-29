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
            'divisi' => DB::table('divisi')->get()
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
}
