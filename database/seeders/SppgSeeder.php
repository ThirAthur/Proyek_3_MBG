<?php

namespace Database\Seeders;

use App\Models\Sppg;
use Illuminate\Database\Seeder;

class SppgSeeder extends Seeder
{
    public function run(): void
    {
        $sppgs = [
            [
                'code' => 'SPPG-001',
                'name' => 'SPPG Contoh 01',
                'address' => 'Alamat SPPG 1'
            ],
            [
                'code' => 'SPPG-002',
                'name' => 'SPPG Contoh 02',
                'address' => 'Alamat SPPG 2'
            ],
        ];

        foreach ($sppgs as $sppg) {
            Sppg::updateOrCreate(
                ['code' => $sppg['code']],
                [
                    'name' => $sppg['name'],
                    'address' => $sppg['address'],
                ]
            );
        }
    }
}