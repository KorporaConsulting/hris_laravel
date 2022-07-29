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

        Permission::create([
            'name' => 'index_karyawan',
            'guard_name' => 'web'
        ]);

        $role = Role::find(3);
             
        $role->givePermissionTo(['index_karyawan']);
    }
}
