<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(GroupRoleSeeder::class);
        $this->call(UserGroupPivotSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostMediaSeeder::class);
        $this->call(PostLikeSeeder::class);
        $this->call(PostCommentSeeder::class);
        $this->call(PostSaveSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(NotificationSeender::class);
        $this->call(NotificationTypeSeeder::class);
    }
}
