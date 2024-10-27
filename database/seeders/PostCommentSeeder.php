<?php

namespace Database\Seeders;

use App\Models\PostComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostComment::create([
            'id' => 'PostComment1',
            'user_id' => 'Z',
            'post_id' => 'Post1',
            'comment' => 'mantap bro!'
        ]);
        PostComment::create([
            'id' => 'PostComment2',
            'user_id' => 'YL22VJV8Y',
            'post_id' => 'Post1',
            'comment' => 'tq'
        ]);
    }
}
