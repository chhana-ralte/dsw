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
        Schema::table('allot_hostels',function($table){
            $table->foreignIdFor(App\Models\Allotment::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allot_hostels', function($table) {
            $table->dropColumn('allotment_id');
        });
    }
};
