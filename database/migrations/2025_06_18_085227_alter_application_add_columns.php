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
            $table->string('name')->nullable();
            $table->string('father')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('married')->default(0);
            $table->string('gender')->default('Male');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->boolean('PWD')->default(0);
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->boolean('AMC')->default(0);
            $table->string('emergency')->nullable();
            $table->string('photo')->nullable();
            $table->string('rollno')->nullable();
            $table->string('course')->nullable();
            $table->string('department')->nullable();
            $table->integer('semester')->nullable();
            $table->string('mzuid')->nullable();
            $table->string('percent')->nullable();
            $table->text('reason')->nullable();
            $table->text('remark')->nullable();
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
            $table->dropColumn('married');
            $table->dropColumn('gender');
            $table->dropColumn('mobile');
            $table->dropColumn('email');
            $table->dropColumn('category');
            $table->dropColumn('PWD');
            $table->dropColumn('state');
            $table->dropColumn('address');
            $table->dropColumn('AMC');
            $table->dropColumn('emergency');
            $table->dropColumn('photo');
            $table->dropColumn('rollno');
            $table->dropColumn('course');
            $table->dropColumn('department');
            $table->dropColumn('semester');
            $table->dropColumn('mzuid');
            $table->dropColumn('percent');
            $table->dropColumn('reason');
            $table->dropColumn('remark');
        });
    }
};
