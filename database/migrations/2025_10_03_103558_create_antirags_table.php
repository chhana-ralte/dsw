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
        Schema::create('antirags', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Allotment::class);
            $table->ForeignIdFor(App\Models\User::class);
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antirags');
    }
};
