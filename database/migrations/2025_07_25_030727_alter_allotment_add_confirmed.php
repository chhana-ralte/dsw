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
        Schema::table('allotments', function(Blueprint $table){
            $table->boolean('confirmed')->after('to_dt')->default(0);
        });

        \App\Models\Allotment::where('application_id', 0)->update(['confirmed' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allotments', function(Blueprint $table){
            $table->dropColumn('confirmed');
        });
    }
};
