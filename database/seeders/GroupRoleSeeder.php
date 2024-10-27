<?php

namespace Database\Seeders;

use App\Models\GroupRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupRole::create([
            'type' => 'Member'
        ]);
        GroupRole::create([
            'type' => 'Moderator'
        ]);
        GroupRole::create([
            'type' => 'Admin'
        ]);
    }
}
