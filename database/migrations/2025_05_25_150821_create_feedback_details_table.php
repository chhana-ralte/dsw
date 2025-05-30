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
        Schema::create('feedback_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Feedback::class);
            $table->foreignIdFor(App\Models\FeedbackCriteria::class);
            $table->bigInteger('value')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_details');
    }
};
