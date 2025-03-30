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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Allotment::class);
            $table->foreignIdFor(App\Models\AllotHostel::class);
            $table->foreignIdFor(App\Models\Sessn::class);
            $table->string('detail')->nullable();
            $table->integer('amount')->default(0);
            $table->date('payment_dt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
