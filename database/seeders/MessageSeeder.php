<?php

namespace Database\Seeders;

use App\Models\Message;
use Carbon\Carbon;
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
            "message" => "Hola Amigos !",
            "created_at" => Carbon::create("15-04-2024")
        ]);

        Message::create([
            "id" => str::uuid(),
            "sender_id" => 'YL22VJV8Y',
            "receiver_id" => "Z",
            "message" => "Guten Morgen bruder !",
            "created_at" => Carbon::create("16-04-2024")
        ]);

        Message::create([
            "id" => str::uuid(),
            "sender_id" => "Z",
            "receiver_id" => 'YL22VJV8Y',
            "message" => "How are you ?",
            "created_at" => Carbon::create("17-04-2024")
        ]);
        Message::create([
            "id" => str::uuid(),
            "sender_id" => 'Z',
            "receiver_id" => "YL22VJV8Y",
            "message" => "Fine bro, thanks for asking !",
            "created_at" => Carbon::create("18-04-2024")
        ]);

        Message::create([
            "id" => str::uuid(),
            "sender_id" => "Z",
            "receiver_id" => "DAMN",
            "message" => "Hell ya bro",
        ]);
        Message::create([
            "id" => str::uuid(),
            "sender_id" => "DAMN",
            "receiver_id" => "Z",
            "message" => "What ??",
            "created_at" => Carbon::create("20-04-2024")
        ]);
        Message::create([
            "id" => str::uuid(),
            "sender_id" => "Z",
            "receiver_id" => "DAMN",
            "message" => "nothing hehe",
            "created_at" => Carbon::create("21-04-2024")
        ]);
    }
}
