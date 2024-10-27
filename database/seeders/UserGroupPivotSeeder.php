<?php

namespace Database\Seeders;

use App\Models\UserGroupPivot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGroupPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserGroupPivot::create([
            'user_id' => 'YL22VJV8Y',
            'group_id' => 'group2',
            'user_group_status_id' => 2
        ]);
        UserGroupPivot::create([
            'user_id' => 'MFA',
            'group_id' => 'furry',
            'user_group_status_id' => 2
        ]);
        UserGroupPivot::create([
            'user_id' => 'YL22VJV8Y',
            'group_id' => 'furry',
            'group_role_id' => 3
        ]);
        UserGroupPivot::create([
            'user_id' => 'Z',
            'group_id' => 'furry',
            'group_role_id' => 3,
            'user_group_status_id' => 1
        ]);
    }
}
