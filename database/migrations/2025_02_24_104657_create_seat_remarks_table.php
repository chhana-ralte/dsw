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
        Schema::create('seat_remarks', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Seat::class);
            $table->string('remark');
            $table->date('remark_dt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_remarks');
    }
};
