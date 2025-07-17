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
        $sem_allots = \App\Models\SemAllot::all();
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $len = strlen($chars);
        foreach ($sem_allots as $sa) {
            $str = $chars[rand(0, $len - 1)] . $chars[rand(0, $len - 1)];
            $sa->rand = $str;
            $sa->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
