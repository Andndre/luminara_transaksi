<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\PackagePrice;

class VisualPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Visual: Paket Basic Foto Only',
                'type' => 'visual_basic',
                'description' => '8 jam kerja. 50-60 foto edit. Google Drive.',
                'base_price' => 1300000,
                'prices' => [8 => 1300000]
            ],
            [
                'name' => 'Visual: Paket Standar Foto & Video',
                'type' => 'visual_standar',
                'description' => '8 jam kerja. 70-80 foto edit. Video highlight 3-5 menit.',
                'base_price' => 3000000,
                'prices' => [8 => 3000000]
            ],
            [
                'name' => 'Graduation: Paket 1',
                'type' => 'grad_1',
                'description' => '1 Wisudawan/Wati. 30 Menit. 30 File Edit.',
                'base_price' => 250000,
                'prices' => [1 => ['price' => 250000, 'desc' => '30 Menit']]
            ],
            [
                'name' => 'Graduation: Paket 2',
                'type' => 'grad_2',
                'description' => '1 Wisudawan/Wati. 60 Menit. 80 File Edit.',
                'base_price' => 400000,
                'prices' => [1 => ['price' => 400000, 'desc' => '60 Menit']]
            ],
            [
                'name' => 'Graduation: Paket 3',
                'type' => 'grad_3',
                'description' => '1 Wisudawan/Wati. 60 Menit. 40 Foto Edit + 1 Menit Video.',
                'base_price' => 700000,
                'prices' => [1 => ['price' => 700000, 'desc' => '60 Menit']]
            ],
        ];

        foreach ($packages as $pkgData) {
            $package = Package::updateOrCreate(
                ['type' => $pkgData['type']],
                [
                    'name' => $pkgData['name'],
                    'description' => $pkgData['description'],
                    'base_price' => $pkgData['base_price'],
                    'is_active' => true,
                    'business_unit' => 'visual',
                ]
            );

            // Sync Prices
            $package->prices()->delete();
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
