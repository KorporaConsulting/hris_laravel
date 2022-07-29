<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index ()
    {
        return view('pengumuman.index', [
            'announcements' => Pengumuman::with('created_by')->get()
        ]);

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
}
