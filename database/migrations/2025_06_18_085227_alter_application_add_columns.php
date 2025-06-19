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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('name');
            $table->string('father');
            $table->date('dob');
            $table->boolean('married')->default(0);
            $table->string('gender');
            $table->string('mobile');
            $table->string('email');
            $table->string('category');
            $table->boolean('PWD')->default(0);
            $table->string('state');
            $table->string('address');
            $table->boolean('AMC')->default(0);
            $table->string('emergency')->nullable();
            $table->string('photo')->nullable();
            $table->string('rollno')->nullable();
            $table->string('course');
            $table->string('department');
            $table->integer('semester');
            $table->string('mzuid')->nullable();
            $table->string('percent')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('father');
            $table->dropColumn('dob');
            $table->dropColumn('married')->default(0);
            $table->dropColumn('gender');
            $table->dropColumn('mobile');
            $table->dropColumn('email');
            $table->dropColumn('category');
            $table->dropColumn('PWD')->default(0);
            $table->dropColumn('state');
            $table->dropColumn('address');
            $table->dropColumn('AMC')->default(0);
            $table->dropColumn('emergency')->nullable();
            $table->dropColumn('photo')->nullable();
            $table->dropColumn('rollno')->nullable();
            $table->dropColumn('course');
            $table->dropColumn('department');
            $table->dropColumn('semester');
            $table->dropColumn('mzuid')->nullable();
            $table->dropColumn('percent')->nullable;
        });
    }
};
