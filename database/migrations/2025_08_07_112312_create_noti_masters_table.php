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
        Schema::create('noti_masters', function (Blueprint $table) {
            $table->id();
            $table->string('no', 50);
            $table->string('subject')->nullable();
            $table->string('type')->nullable();
            $table->date('dt')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noti_masters');
    }
};
