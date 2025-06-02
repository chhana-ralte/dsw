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
        Schema::table('people', function (Blueprint $table) {
            $table->string('gender')->nullable();
        });

        // Update existing records to set a default value
        $allotments = \App\Models\Allotment::all();

        foreach ($allotments as $allotment) {
            $allotment->person->gender = $allotment->hostel->gender;
            $allotment->person->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
