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
        Schema::table('applications', function(Blueprint $table){
            $table->string('PWD_proof')->after('PWD')->nullable();
            $table->string('BPL', 5)->after('PWD_proof')->default('None');
            $table->string('BPL_proof')->after('BPL')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function(Blueprint $table){
            $table->dropColumn('PWD_proof');
            $table->dropColumn('BPL');
            $table->dropColumn('BPL_proof');
        });
    }
};
