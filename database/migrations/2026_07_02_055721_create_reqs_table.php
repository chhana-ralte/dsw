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
        Schema::create('reqs', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\AllotHostel::class);
            $table->bigInteger('from_hostel_id');
            $table->bigInteger('to_hostel_id');
            $table->integer('recommended1_by')->default(0);
            $table->date('recommended1_on')->nullable();
            $table->integer('recommended2_by')->default(0);
            $table->date('recommended2_on')->nullable();
            $table->Integer('approved_by')->default(0);
            $table->date('approved_on')->nullable();
            $table->string('status', 30)->default('Applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reqs');
    }
};
