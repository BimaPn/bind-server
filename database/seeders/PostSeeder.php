<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'id' => 'Post1',
            'user_id' => 'YL22VJV8Y',
            'caption' => 'post pertama wkwkwk'
        ]);
        Post::create([
            'id' => 'Post2',
            'user_id' => 'YL22VJV8Y',
            'caption' => 'post kedua wkwkwk'
        ]);
        Post::create([
            'id' => 'Post4',
            'user_id' => 'YL22VJV8Y',
            'group_id' => 'furry',
            'caption' => 'post ketiga wkwkwk'
        ]);
        Post::create([
            'id' => 'Post3',
            'user_id' => 'MFA',
            'caption' => 'post ketiga wkwkwk'
        ]);
    }
}
