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
        Schema::create('allotments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Person::class);
            $table->foreignIdFor(App\Models\Notification::class);
            $table->foreignIdFor(App\Models\Hostel::class);
            $table->date('from_dt')->nullable();
            $table->date('to_dt')->nullable();
            $table->boolean('admitted')->default(0);
            $table->boolean('valid')->default(1);
            $table->boolean('finished')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allotments');
    }
};
