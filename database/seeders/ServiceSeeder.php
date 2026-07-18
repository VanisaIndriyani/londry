<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Cuci & Lipat',
                'price' => 7000,
                'unit' => 'kg',
                'estimated_days' => 1,
                'description' => 'Layanan praktis untuk pakaian harian Anda. Bersih, wangi, dan rapi terlipat.',
                'is_active' => true,
            ],
            [
                'name' => 'Cuci & Setrika',
                'price' => 10000,
                'unit' => 'kg',
                'estimated_days' => 1,
                'description' => 'Pakaian bersih dan tersetrika licin sempurna, siap langsung masuk lemari.',
                'is_active' => true,
            ],
            [
                'name' => 'Dry Cleaning',
                'price' => 25000,
                'unit' => 'item',
                'estimated_days' => 2,
                'description' => 'Perawatan khusus untuk jas, gaun, dan bahan sensitif lainnya.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
