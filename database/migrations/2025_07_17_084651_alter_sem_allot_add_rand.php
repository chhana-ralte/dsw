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
        Schema::table('sem_allots', function (Blueprint $table) {
            $table->string('rand', 5)->default('xf')->after('valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sem_allots', function (Blueprint $table) {
            $table->dropColumn('rand');
        });
    }
};
