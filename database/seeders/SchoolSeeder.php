<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            ['name' => 'SDN Contoh 01', 'address' => 'Alamat sekolah 1'],
            ['name' => 'SDN Contoh 02', 'address' => 'Alamat sekolah 2'],
            ['name' => 'SMP Contoh 01', 'address' => 'Alamat sekolah 3'],
        ];

        foreach ($schools as $school) {
            School::updateOrCreate(
                ['name' => $school['name']],
                ['address' => $school['address']]
            );
        }
    }
}