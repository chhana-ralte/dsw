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
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Person::class);
            $table->foreignIdFor(App\Models\User::class);
            $table->foreignIdFor(App\Models\AllotHostel::class);

            $table->integer('for_sessn_id');
            $table->foreignIdFor(App\Models\Hostel::class);
            $table->integer('roomcapacity')->nullable();
            $table->boolean('same')->default(true);
            $table->string('type')->default('Next Semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
