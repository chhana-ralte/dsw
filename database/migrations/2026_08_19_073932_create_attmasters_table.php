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
        Schema::create('attmasters', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\User::class);
            $table->ForeignIdFor(App\Models\Course::class);
            $table->ForeignIdFor(App\Models\Sessn::class);
            $table->string('subject_code', 20);
            $table->string('subject_name', 100);
            $table->integer('semester');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attmasters');
    }
};
