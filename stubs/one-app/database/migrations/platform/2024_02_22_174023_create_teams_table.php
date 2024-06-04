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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index()->unique();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->string('domain')->nullable()->index()->unique();
            $table->boolean('personal_team');
            $table->text('profile_photo_path')->nullable();
            $table->foreignId('datastore_id')->nullable()->index();
            $table->text('contact_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
