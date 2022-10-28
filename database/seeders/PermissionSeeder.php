<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            'karyawan.create',
            'karyawan.delete',
            'karyawan.update',
            'karyawan.read',
            'index_karyawan',

            'kehadiran.read',

            'pengumuman.create',
            'pengumuman.update',
            'pengumuman.delete',

            'polling.create',
            'polling.read',
            'polling.update',
            'polling.delete',

            'cuti.read',

            'event.create',
            'event.read',
            'event.update',
            'event.delete',

            'restore',

            'divisi.read',
            'divisi.create'
        ];

        foreach ($permission as $data) {
            Permission::create(['name' => $data]);
        }
    }
}
