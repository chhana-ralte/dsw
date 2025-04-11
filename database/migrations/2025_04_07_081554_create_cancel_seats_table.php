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
        Schema::create('cancel_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Allotment::class);
            $table->foreignIdFor(App\Models\AllotHostel::class)->nullable();
            $table->foreignIdFor(App\Models\AllotSeat::class)->nullable();
            $table->foreignIdFor(App\Models\User::class)->nullable();
            $table->date('issue_dt')->nullable();
            $table->date('leave_dt')->nullable();
            $table->boolean('cleared')->default('1');
            $table->boolean('finished')->default('1');
            $table->integer('outstanding')->default(0);
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_seats');
    }
};
