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
            $table->integer('acad_score')->after('reason')->default(0);
            $table->integer('PWD_score')->after('acad_score')->default(0);
            $table->integer('BPL_score')->after('PWD_score')->default(0);
            $table->integer('loc_score')->after('BPL_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function(Blueprint $table){
            $table->dropColumn('acad_score');
            $table->dropColumn('PWD_score');
            $table->dropColumn('BPL_score');
            $table->dropColumn('loc_score');
        });
    }
};
