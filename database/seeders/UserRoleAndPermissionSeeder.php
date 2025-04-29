<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRole('admin');
        $this->createRole('customer');
    }

    private function createRole($roleName): \Spatie\Permission\Contracts\Role|Role
    {
        return Role::create(['name' => $roleName]);
    }
}
