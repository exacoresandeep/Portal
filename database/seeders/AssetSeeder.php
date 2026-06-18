<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Dell Latitude 7420',
            'HP EliteBook 840',
            'Lenovo ThinkPad T14'
        ];

        $vendors = [
            'RAC',
            'Exacore',
            'Ensource'
        ];

        for ($i=1;$i<=15;$i++) {

            \App\Models\Asset::create([

                'employee_id' => rand(1,10),

                'laptop_brand' => $brands[array_rand($brands)],

                'asset_no' => 'EJ2234'.rand(100,999),

                'vendor' => $vendors[array_rand($vendors)],

                'mouse_code' => 'MS26'.rand(100,999),

                'serial_no' => 'MS26'.rand(100,999),

                'ram' => rand(0,1) ? '16 GB' : '32 GB',

                'sys_config' =>
                    'Intel(R) Core(TM) i5-2430M CPU @ 2.40GHz',

                'os_version' => '64 Bit Windows 11',

                'transfer_at' => now()->subDays(rand(1,180)),

                'status' => 'active'
            ]);
        }
    }
}
