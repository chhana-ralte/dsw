<?php

use App\Models\Course;
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
        Schema::create('zirlais', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('rollno', 20);
            $table->string('mzuid', 20)->nullable();
            $table->foreignIdFor(Course::class)->constrained();
            $table->integer('semester')->default(0);
            $table->integer('start_yr')->default(2025);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zirlais');
    }
};
