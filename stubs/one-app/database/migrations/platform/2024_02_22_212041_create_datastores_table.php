<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datastores', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index()->unique();
            $table->string('name')->index()->unique();
            $table->text('migration_path')->nullable();
            $table->string('driver');
            $table->nullableMorphs('owner');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datastores');
    }
};
