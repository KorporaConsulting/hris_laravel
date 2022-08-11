<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Carbon\Carbon;


class Helper
{
    public static function getDateByDayInWeek($date, $startDay)
    {
        $date = new Carbon($date);

        $weekEndDate = $date->endOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i:s');
        $weekStartDate = $date->startOfWeek(Carbon::MONDAY)->format('Y-m-d H:i:s');

        // switch ($startDaye) {
        //     case 'value':
        //         # code...
        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }
        
        if ($startDay == 'monday') {
            $reminderDate = $date->startOfWeek(Carbon::MONDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'tuesday') {

            $reminderDate = $date->startOfWeek(Carbon::TUESDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'wednesday') {

            $reminderDate = $date->startOfWeek(Carbon::WEDNESDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'thursday') {

            $reminderDate = $date->startOfWeek(Carbon::THURSDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'friday') {

            $reminderDate = $date->startOfWeek(Carbon::FRIDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'saturday') {

            $reminderDate = $date->startOfWeek(Carbon::SATURDAY)->format('Y-m-d H:i:s');
        } else if ($startDay == 'sunday') {

            $reminderDate = $date->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i:s');
        } else {
            $weekStartDate = 'gada coy';
            $reminderDate = 'gada coy';
            $weekEndDate = 'gada coy';
        }

        return $reminderDate;
    }

    public static function shout(string $string)
    {
        return strtoupper($string);
    }
}
