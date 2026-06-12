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
        Schema::table('admissions', function(Blueprint $table){
            $table->unsignedBigInteger('updated_by')->after('payment_dt')->default(0);
            $table->boolean('verified')->after('updated_by')->default(0);
            $table->unsignedBigInteger('verified_by')->after('verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function(Blueprint $table){
            $table->dropColumn('updated_by');
            $table->dropColumn('verified');
            $table->dropColumn('verified_by');
        });
    }
};
