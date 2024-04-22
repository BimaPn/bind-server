<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\UserGroupPivot;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostMedia;
use App\Models\PostComment;
use App\Models\PostSave;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Role
        $this->call(RoleSeeder::class);

        // User
        $this->call(UserSeeder::class);
        // User::factory(20)->create();

        // Group
        $this->call(GroupSeeder::class);
        // Group::factory(20)->create();
        $this->call(GroupRoleSeeder::class);
        $this->call(UserGroupPivotSeeder::class);
        // UserGroupPivot::factory(20)->create();

        // Post
        // Post::factory(20)->create();
        $this->call(PostSeeder::class);
        $this->call(PostMediaSeeder::class);
        // PostMedia::factory(20)->create();
        $this->call(PostLikeSeeder::class);
        $this->call(PostCommentSeeder::class);
        $this->call(PostSaveSeeder::class);
        $this->call(MessageSeeder::class);
        // PostLike::factory(20)->create();
        // PostSave::factory(10)->create();
        // PostComment::factory(20)->create();
    }
}
