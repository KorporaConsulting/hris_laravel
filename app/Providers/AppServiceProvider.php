<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        Blade::directive('tanggal', function ($timestamp) {
            $unixtime =  strtotime($timestamp);
            $datetime = date("d M Y - h:i A", $unixtime);

            $day = date("D", $unixtime);

            switch ($day) {
                case "Mon":
                    $hari = "Senin";
                    break;
                case "Tue":
                    $hari = "Selasa";
                    break;
                case "Wed":
                    $hari = "Rabu";
                    break;
                case "Thu":
                    $hari = "Kamis";
                    break;
                case "Fri":
                    $hari = "Jum'at";
                    break;
                case "Sat":
                    $hari = "Sabtu";
                    break;
                case "Sun":
                    $hari = "Minggu";
                    break;
            }

            return "$hari, $datetime";
        });
    }
}
