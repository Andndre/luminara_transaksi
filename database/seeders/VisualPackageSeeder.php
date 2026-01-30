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
            // Wedding & Event Documentation
            [
                'name' => 'Visual: Paket Basic Foto Only',
                'type' => 'visual_basic',
                'description' => "8 jam kerja\nSemua file foto (softcopy)\n50-60 foto di-edit\nDikirim melalui Google Drive",
                'base_price' => 1300000,
                'prices' => [8 => 1300000]
            ],
            [
                'name' => 'Visual: Paket Standar Foto & Video',
                'type' => 'visual_standar',
                'description' => "8 jam kerja\nSemua file foto (softcopy)\n70-80 foto di-edit\nVideo dokumentasi full acara 3-5 menit\nDikirim melalui Google Drive",
                'base_price' => 3000000,
                'prices' => [8 => 3000000]
            ],
            [
                'name' => 'Visual: Paket Premium Foto & Video',
                'type' => 'visual_premium',
                'description' => "8 jam kerja\nSemua file foto (softcopy)\n100+ foto di-edit\nAlbum Kolase Foto\nVideo highlight 1-2 menit\nVideo dokumentasi full acara 5-8 menit\nDrone Shot\nDikirim melalui Google Drive & Flashdisk\nFree Transport (Seluruh Bali)",
                'base_price' => 5000000, // Placeholder price as not specified in text
                'prices' => [8 => 5000000]
            ],
            // Graduation Sessions
            [
                'name' => 'Graduation: Paket 1',
                'type' => 'grad_1',
                'description' => "1 Wisudawan/Wati\n30 Menit Pemotretan\n30 File Foto Edit\nSemua File Original\nSoftcopy via Google Drive",
                'base_price' => 250000,
                'prices' => [1 => ['price' => 250000, 'desc' => '30 Menit']]
            ],
            [
                'name' => 'Graduation: Paket 2',
                'type' => 'grad_2',
                'description' => "1 Wisudawan/Wati\n60 Menit Pemotretan\n80 File Foto Edit\nSemua File Original\nSoftcopy via Google Drive",
                'base_price' => 400000,
                'prices' => [1 => ['price' => 400000, 'desc' => '60 Menit']]
            ],
            [
                'name' => 'Graduation: Paket 3',
                'type' => 'grad_3',
                'description' => "1 Wisudawan/Wati\n60 Menit Pemotretan\n40 File Foto Edit\n1 Menit Video Highlight\nSemua File Original\nSoftcopy via Google Drive",
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
