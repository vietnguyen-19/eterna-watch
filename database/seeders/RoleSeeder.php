<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'user', 'guard_name' => 'web'],
            ['name' => 'employee', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web'],
        ]);
    }
}
