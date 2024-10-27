<?php

namespace Database\Seeders;

use App\Models\UserGroupStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGroupStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserGroupStatus::create([
            'status' => 'Active'
        ]);
        UserGroupStatus::create([
            'status' => 'Banned'
        ]);
        UserGroupStatus::create([
            'status' => 'Muted'
        ]);
    }
}
