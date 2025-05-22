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
        Schema::create('feedback_masters', function (Blueprint $table) {
            $table->id();
            $table->String('title');
            $table->Text('remark')->nullable();
            $table->Date('from_dt')->nullable();
            $table->Date('to_dt')->nullable();
            $table->Boolean('open')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_masters');
    }
};
