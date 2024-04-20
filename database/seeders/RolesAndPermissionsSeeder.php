<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);

        // Create permissions (if needed)
        // $manageUsersPermission = Permission::create(['name' => 'manage users']);

        // Assign permissions to roles (if needed)
        // $adminRole->givePermissionTo($manageUsersPermission);

        // Find a user by UUID and assign roles to them
        $user = User::find('YL22VJV8Y');
        $user->assignRole($adminRole);
    }
}
