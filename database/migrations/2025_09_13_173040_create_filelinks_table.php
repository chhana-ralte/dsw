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
        Schema::create('filelinks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\File::class);
            $table->string('type', 30);
            $table->bigInteger('foreign_id');
            $table->string('tagname', 30);
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filelinks');
    }
};
