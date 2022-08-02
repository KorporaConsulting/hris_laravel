<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function index ()
    {
        return view('pengumuman.index', [
            'announcements' => Pengumuman::with('created_by')->get()
        ]);

    }

    public function show (Pengumuman $pengumuman)
    {
        $pengumuman->load('created_by');

        return view('pengumuman.show', compact('pengumuman'));
    }

    public function create ()
    {        
        return view('pengumuman.create', [
            'users' => User::get()
        ]);
    }


    public function store ()
    {

        $pengumuman = Pengumuman::create([
                'user_id'       => auth()->id(),
                'judul'         => request('judul'),
                'deskripsi'     => request('deskripsi'),
                'date_start'    => request('date_start'),
                'date_end'      => request('date_end'),
                'judul'         => request('judul'),
        ]);

        $pengumuman->users()->attach(request('to'));

        return redirect()->route('user.dashboard')->with('success', 'Berhasil membuat pengumuman');
    }

    public function edit (Pengumuman $pengumuman)
    {
        $pengumuman->load('users');

        $users = DB::table('users')->get();
        return view('pengumuman.edit', compact('pengumuman', 'users'));
    }

    public function update (Pengumuman $pengumuman)
    {
        
        $pengumuman->update([
            'judul'         => request('judul'),
            'deskripsi'     => request('deskripsi'),
            'date_start'    => request('date_start'),
            'date_end'      => request('date_end'),
            'judul'         => request('judul'),
        ]);

        $pengumuman->users()->sync(request('to'));

        return redirect()->route('pengumuman.index')->with('success', 'Berhasil mengedit pengumuman');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->users()->detach();
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Berhasil menghapus pengumuman');
    }
}
