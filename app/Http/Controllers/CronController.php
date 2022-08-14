<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function checkAlpha(){

        $job = new \App\Jobs\KehadiranChecking;
        $job->handle();
    }
}
