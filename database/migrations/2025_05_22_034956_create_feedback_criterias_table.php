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
        Schema::create('feedback_criterias', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(FeedbackMaster::class);
            $table->Integer('serial')->nullable();
            $table->Text('criteria');
            $table->string('type')->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_criterias');
    }
};
