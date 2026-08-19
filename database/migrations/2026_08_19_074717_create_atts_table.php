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
        Schema::create('atts', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Std::class);
            $table->ForeignIdFor(App\Models\Attslot::class);
            $table->string('marking',10)->default('P');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atts');
    }
};
