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
        Schema::table('applications', function (Blueprint $table) {
            $table->boolean('admitted')->after('valid')->default(0);
        });
        $sql = "UPDATE applications JOIN allotments ON applications.id=allotments.application_id
            JOIN admissions ON allotments.id=admissions.allotment_id
            SET applications.admitted=1";
        DB::select($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('admitted');
        });
    }
};
