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
        Schema::create('stds', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Course::class);
            $table->string('rollno', 10);
            $table->string('name', 50);
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stds');
    }
};
