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

        $permission = Permission::upsert([
            [
                'name' => 'polling.create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'polling.read',
                'guard_name' => 'web',
            ],
            [
                'name' => 'polling.update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'polling.delete',
                'guard_name' => 'web',
            ],
        ], ['name', 'guard_name']);


        $role = Role::find(1);
        $role->givePermissionTo(['polling.create', 'polling.read', 'polling.update', 'polling.delete']);
        
        // $role = Role::find(3);
        // $role->givePermissionTo('pengumuman.create');

    }
}
