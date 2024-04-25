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
        Schema::create('last_seen_messages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("user_id");
            $table->foreignUuid("target_id");
            $table->timestamp("last_seen");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_seen_messages');
    }
};
