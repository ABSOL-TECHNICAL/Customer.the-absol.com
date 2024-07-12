<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database with permissions.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            'View',
            'Reject',
            'Approve',
            'Verify',
            'Edit',
        ];


        foreach ($permissions as $permissionName) {

            $permission = Permission::where('name', $permissionName)->first();

            if (!$permission) {

                Permission::create(['name' => $permissionName]);
            }
        }
    }
}
