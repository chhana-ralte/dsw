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
        Schema::table('requirements', function (Blueprint $table) {
            $table->integer('new_hostel_id')->default(0);
            $table->integer('new_roomcapacity')->default(0);
            $table->boolean('notified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn('new_hostel_id');
            $table->dropColumn('new_roomcapacity');
            $table->dropColumn('notified');
        });
    }
};
