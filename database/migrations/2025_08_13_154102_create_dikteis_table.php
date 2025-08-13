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
        Schema::create('dikteis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Zirlai::class)->constrained();
            $table->integer('serial')->default(0);
            $table->foreignIdFor(\App\Models\Subject::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dikteis');
    }
};
