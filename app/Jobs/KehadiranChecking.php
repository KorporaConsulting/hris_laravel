<?php

namespace App\Jobs;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KehadiranChecking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
                'type'    => 'alpha'
            ];
        }

        Kehadiran::upsert($kehadiran, [
            'user_id', 'type'
        ]);

    }
}
