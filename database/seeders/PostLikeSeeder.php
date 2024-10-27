<?php

namespace Database\Seeders;

use App\Models\PostLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostLike::create([
            'id' => 'PostLike1',
            'user_id' => 'Z',
            'post_id' => 'Post1'
        ]);
        PostLike::create([
            'id' => 'PostLike2',
            'user_id' => 'YL22VJV8Y',
            'post_id' => 'Post1'
        ]);
    }
}
