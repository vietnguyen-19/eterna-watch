<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        // Thương hiệu gốc (Cấp 1)
        $brands = [
            'Rolex',
            'Omega',
            'TAG Heuer',
            'Seiko',
            'Casio',
            'Tissot',
            'Citizen',
            'Fossil',
            'Garmin',
            'Apple'
        ];

        $parentIds = [];

        foreach ($brands as $brand) {
            $parentIds[$brand] = Brand::create([
                'name' => $brand,
                'parent_id' => null,
            ])->id;
        }

        // Thương hiệu con (Cấp 2)
        $subBrands = [
            'Rolex' => ['Submariner', 'Daytona', 'Datejust'],
            'Omega' => ['Speedmaster', 'Seamaster', 'Constellation'],
            'TAG Heuer' => ['Carrera', 'Aquaracer', 'Monaco'],
            'Seiko' => ['Presage', 'Prospex', 'Seiko 5'],
            'Casio' => ['G-Shock', 'Edifice', 'Sheen'],
            'Tissot' => ['PRX', 'Le Locle', 'Seastar'],
            'Citizen' => ['Eco-Drive', 'Promaster', 'Quartz'],
            'Fossil' => ['Hybrid', 'Smartwatch', 'Chronograph'],
            'Garmin' => ['Fenix', 'Forerunner', 'Venu'],
            'Apple' => ['Apple Watch Series 9', 'Apple Watch SE', 'Apple Watch Ultra'],
        ];

        foreach ($subBrands as $parent => $subs) {
            foreach ($subs as $sub) {
                Brand::create([
                    'name' => $sub,
                    'parent_id' => $parentIds[$parent],
                ]);
            }
        }
    }
}

