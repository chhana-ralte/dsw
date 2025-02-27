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
        Schema::create('allot_hostels', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Person::class);
            $table->ForeignIdFor(App\Models\Hostel::class);
            $table->date('from_dt')->nullable();
            $table->date('to_dt')->nullable();
            $table->date('leave_dt')->nullable();
            $table->boolean('valid')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allot_hostels');
    }
};
