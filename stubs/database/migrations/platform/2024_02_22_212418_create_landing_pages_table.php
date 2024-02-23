<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('model');

            $table->uuid('uuid')->unique();

            $table->string('name')->nullable();

            $table->string('landing_page_path', 2048)->nullable();

            $table->timestamps();
        });
    }
};
