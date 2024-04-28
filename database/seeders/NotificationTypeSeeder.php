<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationType;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationType::create([
            "type" => "followed",
            "message" => "Followed you."
        ]);
        NotificationType::create([
            "type" => "liked_post",
            "message" => "Liked your post."
        ]);
        NotificationType::create([
            "type" => "commented_post",
            "message" => "Commented your post."
        ]);
    }
}
