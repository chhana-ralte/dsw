<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('allot_hostels', function (Blueprint $table) {
            $table->boolean('valid_backup')->default(0)->after('valid');
        });

        DB::table('allot_hostels')->where('valid', 1)->update(['valid_backup' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allot_hostels', function (Blueprint $table) {
            $table->dropColumn('valid_backup');
        });
    }
};
