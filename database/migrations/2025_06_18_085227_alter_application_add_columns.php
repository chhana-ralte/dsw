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
        Schema::table('applications',function(Blueprint $table){
            $table->string('name');
            $table->string('father');
            $table->date('dob');
            $table->string('gender');
            $table->string('mobile');
            $table->string('email');
            $table->string('category');
            $table->string('state');
            $table->string('address');
            $table->boolean('AMC');
            $table->string('photo');
            $table->string('rollno');
            $table->string('course');
            $table->string('department');
            $table->integer('semester');
            $table->string('mzuid')->nullable();
            $table->string('percent');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications',function(Blueprint $table){
            $table->dropColumn('name');
            $table->dropColumn('father');
            $table->dropColumn('dob');
            $table->dropColumn('gender');
            $table->dropColumn('mobile');
            $table->dropColumn('email');
            $table->dropColumn('category');
            $table->dropColumn('state');
            $table->dropColumn('address');
            $table->dropColumn('AMC');
            $table->dropColumn('photo');
            $table->dropColumn('rollno');
            $table->dropColumn('course');
            $table->dropColumn('department');
            $table->dropColumn('semester');
            $table->dropColumn('mzuid')->nullable();
            $table->dropColumn('percent');

        });
    }
};
