<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'id' => 'furry',
            'name' => 'KOMUNITAS FURY INDONESIA',
            'description' => 'FURY INDONESIA!! SOLID! SOLID! SOLID!'
        ]);
        Group::create([
            'id' => 'group2',
            'name' => 'INI GROUP 2',
            'description' => 'ldelkcsdlnkcnsdncsdngvpnwrgnrenglknsdfglnkdlkn'
        ]);
    }
}
