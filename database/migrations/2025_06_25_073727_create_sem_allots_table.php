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
        Schema::create('sem_allots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Notification::class);
            $table->foreignIdFor(\App\Models\Requirement::class)->nullable();
            $table->foreignIdFor(\App\Models\Allotment::class);
            $table->foreignIdFor(\App\Models\Sessn::class);
            $table->boolean('valid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sem_allots');
    }
};
