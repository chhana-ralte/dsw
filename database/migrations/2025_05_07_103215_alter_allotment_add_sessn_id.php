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
        Schema::table('allotments', function (Blueprint $table) {
            $table->BigInteger('start_sessn_id')->nullable();
            $table->BigInteger('end_sessn_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allotments', function (Blueprint $table) {
            $table->DropColumn('start_sessn_id');
            $table->DropColumn('end_sessn_id');
        });
    }
};
