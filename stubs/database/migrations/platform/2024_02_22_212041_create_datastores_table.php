<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection()
    {
        return config('database.platform', 'testing');
    }

    public function up()
    {
        Schema::create('datastores', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('name')->index()->unique();
            $table->string('driver');
            $table->nullableMorphs('owner');
            $table->timestamps();
        });
    }
};
