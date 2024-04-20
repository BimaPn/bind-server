<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('role_id')->default(1);
            $table->string('name',30);
            $table->string('username',16)->unique();
            $table->string('phone',22)->nullable()->unique();
            $table->string('email',40)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender',['Male','Female'])->nullable();
            $table->string('address')->nullable();
            $table->string('profile_picture')->default(url('/storage/user/profile/default.jpg'));
            $table->string('cover_photo')->default(url('/storage/user/cover/default.jpg'));
            $table->string('bio')->nullable();
            $table->boolean('isVerified')->default(false);
            $table->rememberToken();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
