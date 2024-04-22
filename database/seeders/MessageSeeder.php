<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::create([
            "id" => str::uuid(),
            "sender_id" => "Z",
            "receiver_id" => 'YL22VJV8Y',
            "message" => "Hola Amigos !"
        ]);

        Message::create([
            "id" => str::uuid(),
            "sender_id" => 'YL22VJV8Y',
            "receiver_id" => "Z",
            "message" => "Guten Morgen bruder !"
        ]);
    }
}
