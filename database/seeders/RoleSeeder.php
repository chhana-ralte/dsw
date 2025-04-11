<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role' => 'Admin',
            'level' => 5
        ]);
        DB::table('roles')->insert( [
            'role' => 'DSW',
            'level' => 4
        ]);
        DB::table('roles')->insert([
            'role' => 'Warden',
            'level' => 3
        ]);
    }
}
