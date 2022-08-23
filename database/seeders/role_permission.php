<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class role_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // User::find(38)->syncRoles('Super Admin');
    //     Permission::create([
    //         'name' => 'restore',
    //         'guard_name' => 'web'
    //     ]);

        Role::find(1)->givePermissionTo('karyawan.edit');

    }
}
