<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Database\Seeders\role_permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
       $this->call([
            role_permission::class
       ]);
    }
}
