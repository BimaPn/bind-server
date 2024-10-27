<?php

namespace Database\Seeders;

use App\Models\Role;
// use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'type' => 'User',
        ]);
        Role::create([
            'type' => 'Moderator',
        ]);
        Role::create([
            'type' => 'Administrator',
        ]);
        Role::create([
            'type' => 'Developer',
        ]);
    }
}
