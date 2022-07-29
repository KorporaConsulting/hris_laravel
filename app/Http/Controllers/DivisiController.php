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

        $divisions =  Divisi::with('users')->where('id', $id)->firstOrFail();

        // return $divisions;
        return view('divisi.show', compact('divisions'));
    }
}
