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
        Schema::create('person_remarks', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\Person::class);
            $table->string('remark');
            $table->integer('score')->default(0);
            $table->date('remark_dt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_remarks');
    }
};
