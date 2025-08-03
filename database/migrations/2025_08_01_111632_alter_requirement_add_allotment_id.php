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
            $table->unsignedInteger('allotment_id')->default('0')->after('allot_hostel_id');
        });

        foreach (\App\Models\Requirement::where('id', '>', 0)->get() as $req) {
            $req->allotment_id = $req->allot_hostel->allotment_id;
            $req->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn('allotment_id');
        });
    }
};
