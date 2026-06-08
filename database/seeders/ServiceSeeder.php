<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name' => 'Potong Rambut Classic',
                'description' => 'Potong rambut standar dengan styling rapi.',
                'price' => 75000,
                'duration' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Potong + Cukur Kumis/Jenggot',
                'description' => 'Paket potong dan perapihan brewok.',
                'price' => 120000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Haircut Premium + Shampoo',
                'description' => 'Potong premium dengan shampoo dingin.',
                'price' => 150000,
                'duration' => 75,
                'is_active' => true,
            ],
            [
                'name' => 'Anak-anak (di bawah 12 tahun)',
                'description' => 'Potong rambut anak.',
                'price' => 50000,
                'duration' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($rows as $data) {
            Service::query()->updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['image' => null])
            );
        }
    }
}
