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
        Schema::create('semfees', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(\App\Models\Allotment::class);
            $table->ForeignIdFor(\App\Models\Sessn::class);
            $table->ForeignIdFor(\App\Models\AllotHostel::class);
            $table->ForeignIdFor(\App\Models\User::class);
            $table->integer('roomcapacity');
            $table->boolean('valid')->default('1');
            $table->string('status',20)->default('Applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semfees');
    }
};
