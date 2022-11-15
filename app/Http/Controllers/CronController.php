<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    public function checkAlpha()
    {

        $kehadiran  = [];

        $users = User::with(['kehadiran' => function ($q) {
            $q->whereDate('created_at', date('Y-m-d'));
        }])
            ->get()
            ->filter(function ($value, $key) {

                if ($value->kehadiran->isEmpty()) {
                    return $value;
                }
            });

        foreach ($users as $user) {
            $kehadiran[] = [
                'user_id' => $user->id,
                'type'    => 'tidak absen'
            ];
        }

        Kehadiran::upsert($kehadiran, [
            'user_id', 'type'
        ]);

        return response()->json([
            'success' => true
        ], 200);
    }

    public function cutiBulanan()
    {
        DB::table('karyawan')->where('id', '>', 0)->increment('sisa_cuti', 1);

        return response()->json([
            'success' => true
        ], 200);
    }
}
