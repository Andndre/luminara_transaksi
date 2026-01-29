<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\PackagePrice;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Photobooth Unlimited Print',
                'type' => 'pb_unlimited',
                'description' => 'Cetak Sepuasnya Selama Sesi. Termasuk: Kamera DSLR Canon, Layar 22", Lighting Studio, Fun Props, & Softfile QR.',
                'base_price' => 2000000,
                'prices' => [
                    2 => 2000000, 3 => 2500000, 4 => 3000000, 5 => 3500000, 
                    6 => 4000000, 7 => 4500000, 8 => 5000000, 9 => 5500000, 
                    10 => 6000000, 12 => 7000000
                ]
            ],
            [
                'name' => 'Photobooth Limited Print',
                'type' => 'pb_limited',
                'description' => 'Kuota Cetak Terbatas. Termasuk: Kamera DSLR Canon, Layar 22", Lighting Studio, Fun Props, & Softfile QR.',
                'base_price' => 1300000,
                'prices' => [
                    2 => ['price' => 1300000, 'desc' => '50 Print'],
                    3 => ['price' => 1600000, 'desc' => '80 Print'],
                    4 => ['price' => 1800000, 'desc' => '100 Print'],
                    5 => ['price' => 2500000, 'desc' => '200 Print'],
                    6 => ['price' => 3200000, 'desc' => '300 Print'],
                    7 => ['price' => 3900000, 'desc' => '400 Print'],
                    8 => ['price' => 4400000, 'desc' => '500 Print'],
                    9 => ['price' => 5000000, 'desc' => '600 Print'],
                    10 => ['price' => 5600000, 'desc' => '700 Print'],
                    12 => ['price' => 6500000, 'desc' => '900 Print'],
                ]
            ],
            [
                'name' => 'Photobooth Unlimited File Only',
                'type' => 'pb_file',
                'description' => 'Hanya Softcopy (QR Download). No Print.',
                'base_price' => 1000000,
                'prices' => [
                    2 => 1000000, 3 => 1200000, 4 => 1400000, 5 => 1600000, 
                    6 => 1800000, 7 => 2000000, 8 => 2200000, 9 => 2400000, 
                    10 => 2600000, 12 => 3000000
                ]
            ],
            [
                'name' => 'Videobooth 360',
                'type' => 'videobooth360',
                'description' => 'Unlimited Video, Slowmo/Rewind, Custom Overlay.',
                'base_price' => 2000000,
                'prices' => [
                    2 => 2000000, 3 => 2500000, 4 => 3000000, 5 => 3500000, 
                    6 => 4000000, 7 => 4500000, 8 => 5000000
                ]
            ],
            [
                'name' => 'Combo Package Print',
                'type' => 'combo_unlimited',
                'description' => 'Unlimited Print & Video 360.',
                'base_price' => 3950000,
                'prices' => [
                    2 => 3950000, 3 => 4900000, 4 => 5850000, 5 => 6800000, 
                    6 => 7750000, 8 => 9650000, 10 => 11500000
                ]
            ],
            [
                'name' => 'Combo File Only',
                'type' => 'combo_file',
                'description' => 'Unlimited Photobooth (File Only) & Video 360.',
                'base_price' => 2800000,
                'prices' => [
                    2 => 2800000, 4 => 4200000, 6 => 5600000, 8 => 7000000, 
                    10 => 8400000
                ]
            ],
        ];

        foreach ($packages as $pkgData) {
            $package = Package::create([
                'name' => $pkgData['name'],
                'type' => $pkgData['type'],
                'description' => $pkgData['description'],
                'base_price' => $pkgData['base_price'],
                'is_active' => true,
            ]);

            foreach ($pkgData['prices'] as $duration => $data) {
                if (is_array($data)) {
                    $price = $data['price'];
                    $desc = $data['desc'] ?? null;
                } else {
                    $price = $data;
                    $desc = null;
                }

                PackagePrice::create([
                    'package_id' => $package->id,
                    'duration_hours' => $duration,
                    'price' => $price,
                    'description' => $desc
                ]);
            }
        }
    }
}