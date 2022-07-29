<?php

namespace App\Http\Controllers;

use App\Models\{Karyawan, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'name' => request('name'),
            'email' => request('email'),
            'divisi' => request('divisi'),
            'img' => $profile
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

    public function store()
    {


        // return request()->all();

        $user = [
            'name'          => request('name'),
            'email'         => request('email'),
            'password'      => bcrypt(request('password')),
        ];

        $user = User::create($user);

        if(request('level') == 'manager'){
            $user->givePermissionTo(['manage_cuti']);
        }

        $karyawan = Karyawan::create([
            'user_id'           => $user->id,
            'nip'           => request('nip'),
            'jabatan'           => request('jabatan'),
            'gaji'              => str_replace(',', '',request('gaji')),
            'status_user'       => request('status_user'),
            'alamat_ktp'        => request('alamat_ktp'),
            'alamat_domisili'   => request('alamat_domisili'),
            'mulai_kerja'       => request('mulai_kerja'),
            'tmpt_lahir'        => request('tmpt_lahir'),
            'tgl_lahir'         => request('tgl_lahir'),
            'sisa_cuti'         => 0,
            'no_hp'             => request('no_hp'),
            'no_hp_darurat'     => request('no_hp_darurat')
        ]);

        $user->divisions()->attach(request('divisi'), ['status' => request('level')]);

        session()->flash('success', 'Berhasil menambahkan Karyawan');

        return back();
    }
}
