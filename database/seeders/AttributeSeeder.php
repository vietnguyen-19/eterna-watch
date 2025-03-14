<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
     public function run()
     {
        $attributes = [
            ['attribute_name' => 'Màu sắc', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_name' => 'Chống nước', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_name' => 'Chất liệu dây', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_name' => 'Chất liệu mặt kính', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_name' => 'Kiểu máy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['attribute_name' => 'Đường kính mặt', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('attributes')->insert($attributes);
     }}
