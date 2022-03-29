<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\User;
class DashboardController extends Controller
{
    public function user ()
    {
        
        return view('karyawan.index', [
            'user' => Karyawan::where('user_id', auth()->id())->first()
        ]);
    }
}
