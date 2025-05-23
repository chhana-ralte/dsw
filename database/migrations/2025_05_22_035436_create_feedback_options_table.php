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
        Schema::create('feedback_options', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(\App\Models\FeedbackCriteria::class);
            $table->integer('serial')->nullable();
            $table->string('option');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_options');
    }
};
