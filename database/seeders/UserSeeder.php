<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fabian = User::create([
            'id' => 'YL22VJV8Y',
            'role_id' => 4,
            'name' => 'Muhammad Fabian Azhar',
            'username' => 'ubbaayyyyy',
            'phone' => '0895-4042-88345',
            'email' => 'fabianazhar216@gmail.com',
            'password' => Hash::make('12345678'),
            'address' => 'New York City, USA.',
            'gender' => 'Male',
            'bio' => '...182',
            'isVerified' => true
        ]);

        User::create([
            'id' => 'Z',
            'role_id' => 3,
            'name' => 'Bima Putra',
            'username' => 'bimapn',
            'phone' => '0895-4042-8835',
            'email' => 'dadang@gmail.com',
            'password' => Hash::make('12345678'),
            'address' => 'New York City, USA.',
            'gender' => 'Male',
            'bio' => 'Love You',
            'isVerified' => true
        ])->follow($fabian);

        User::create([
            'id' => 'MFA',
            'role_id' => 2,
            'name' => 'Muhammad Fabian Azhar',
            'username' => 'fabian',
            'phone' => '0895-4042-8834',
            'email' => 'fabianazhar@gmail.com',
            'password' => Hash::make('12345678'),
            'address' => 'New York City, USA.',
            'gender' => 'Male',
            'bio' => '...182',
            'isVerified' => true
        ])->follow($fabian);
    }
}
