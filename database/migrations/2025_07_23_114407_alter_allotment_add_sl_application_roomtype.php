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
        Schema::table('allotments', function (Blueprint $table) {
            $table->integer('sl')->nullable()->after('id');
            $table->integer('application_id')->default(0);
            $table->integer('roomtype');
            $table->string('rand', 5)->default('xf')->after('valid');
        });

        $allotments = \App\Models\Allotment::all();
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $len = strlen($chars);
        foreach ($allotments as $a) {
            $str = $chars[rand(0, $len - 1)] . $chars[rand(0, $len - 1)];
            $a->rand = $str;
            $a->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allotments', function (Blueprint $table) {
            $table->dropColumn('sl');
            $table->dropColumn('application_id');
            $table->dropColumn('roomtype');
            $table->dropColumn('rand');
        });
    }
};
