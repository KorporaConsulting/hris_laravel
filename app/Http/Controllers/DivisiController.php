<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{

    public function index ()
    {
        return view('divisi.index',[
            'divisions' =>  DB::table('divisi')->get()
        ]);
    }

    public function show ($id)
    {
        $user = User::where('divisi_id', $id)->get();
        $level = User::where('level', $id)->get();

        // $divisions =  Divisi::with('users')->where('id', $id)->firstOrFail();

        // return $divisions;
        return view('divisi.show', compact('user', 'level'));
    }

    public function create()
    {
        return view('divisi.create', [
            'users' => Divisi::get()
        ]);
    }

    public function store()
    {
        $divisi = Divisi::create([
            'divisi'    => request('divisi')
        ]);

        $divisi->users()->attach(request('to'));
        return redirect()->route('divisi.index')->with('success', 'Berhasil membuat divisi');
    }

    public function edit($id)
    {
        $data = Divisi::find($id);
        return view('divisi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Divisi::find($id);
        $data->divisi = $request->input('divisi');
        $data->update();

        return redirect()->route('divisi.index')->with('success', 'Berhasil mengedit divisi');
    }

    public function destroy ($divisi_id)
    {
        User::whereId($divisi_id)->delete();
        return redirect()->route('divisi.index')->with('success', 'Berhasil menghapus anggota');
    }
}
