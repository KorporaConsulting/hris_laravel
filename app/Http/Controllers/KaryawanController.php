<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class KaryawanController extends Controller
{
    public function index (){
        
        return view('karyawan.index', [
            'users' => User::with('karyawan')->get()
        ]);
    }

    public function store ()
    {
        
    }
}
