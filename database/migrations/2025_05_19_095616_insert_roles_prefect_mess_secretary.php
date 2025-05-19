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
        App\Models\Role::updateOrCreate(
            [
                'role' => 'Prefect',
            ],
            [
                'role' => 'Prefect',
                'level' => 2,
            ]
        );
        App\Models\Role::updateOrCreate(
            [
                'role' => 'Mess Secretary',
            ],
            [
                'role' => 'Mess Secretary',
                'level' => 2,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        App\Models\Role::where('role', 'Prefect')->delete();
        App\Models\Role::where('role', 'Mess Secretary')->delete();
    }
};
