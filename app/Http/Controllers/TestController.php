<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // $url = 'https://kalenderindonesia.com/api/YZ35u6a7sFWN/libur/masehi/' . date('Y/m');
        // $kalender = file_get_contents($url);
        // $kalender = json_decode($kalender, true);
        // $libur = false;
        // $holiday = null;
        // if ($kalender['data'] != false) {
        //     if ($kalender['data']['holiday']['data']) {
        //         foreach ($kalender['data']['holiday']['data'] as $key => $value) {
        //             if ($value['date'] == date('Y-m-d')) {
        //                 $holiday = $value['name'];
        //                 $libur = true;
        //                 break;
        //             }
        //         }
        //     }
        // }

        $date = Carbon::create('2022-08-17');
        $kehadiran = [];
        while (Carbon::create('2022-08-21') >= $date) {
            // print_r()
            $kehadiran[] = [
                'user_id'       =>  request('userId'),
                'type'          =>  'cuti',
                'created_at'    => $date
            ];

            $date = Carbon::create($date->addDays(1));
        }
        
        return $kehadiran;

        // return $kalender;
    }
}
