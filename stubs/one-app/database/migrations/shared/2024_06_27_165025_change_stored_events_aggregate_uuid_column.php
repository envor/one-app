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
        Schema::table('stored_events', function (Blueprint $table) {
            $table->dropIndex('stored_events_aggregate_uuid_index');
            $table->char('aggregate_uuid', 36)->change();
            $table->index('aggregate_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stored_events', function (Blueprint $table) {
            //
        });
    }
};
