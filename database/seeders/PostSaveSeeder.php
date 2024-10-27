<?php

namespace Database\Seeders;

use App\Models\PostSave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostSave::create([
            'id' => 'PostSave1',
            'user_id' => 'Z',
            'post_id' => 'Post1'
        ]);
    }
}
