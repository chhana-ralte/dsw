<?php

use App\Models\CancelSeat;
use App\Models\Allotment;
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
        Schema::create('clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CancelSeat::class)->onDelete('cascade');
            $table->foreignIdFor(Allotment::class)->onDelete('cascade');
            $table->string('hostel');
            $table->string('roomno');
            $table->date('leave_dt');
            $table->date('issue_dt');
            $table->string('name');
            $table->string('rollno');
            $table->string('course');
            $table->string('department');
            $table->string('warden');
            $table->string('status')->default('Cleared');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearances');
    }
};
