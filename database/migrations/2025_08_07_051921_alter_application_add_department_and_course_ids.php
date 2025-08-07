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
            $table->integer('course_id')->after('course')->default(0);
            $table->integer('department_id')->after('department')->default(0);
        });

        foreach (\App\Models\Department::all() as $dept) {
            \App\Models\Application::where('department', $dept->name)->update(['department_id' => $dept->id]);
        }

        foreach (\App\Models\Course::all() as $course) {
            \App\Models\Application::where('course', $course->name)->update(['course_id' => $course->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('department_id');
        });
    }
};
