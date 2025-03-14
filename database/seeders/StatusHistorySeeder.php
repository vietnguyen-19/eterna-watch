<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusHistory;

class StatusHistorySeeder extends Seeder
{
    public function run(): void
    {
        StatusHistory::factory()->count(40)->create();
    }
}
