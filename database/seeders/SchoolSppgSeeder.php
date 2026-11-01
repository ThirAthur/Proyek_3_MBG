<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Sppg;
use Illuminate\Database\Seeder;

class SchoolSppgSeeder extends Seeder
{
    public function run(): void
    {
        $distributions = [
            'SDN Contoh 01' => ['SPPG-001'],
            'SDN Contoh 02' => ['SPPG-001', 'SPPG-002'],
            'SMP Contoh 01' => ['SPPG-002'],
        ];

        foreach ($distributions as $schoolName => $sppgCodes) {
            $school = School::where('name', $schoolName)->first();

            if (!$school) {
                continue;
            }

            $sppgIds = Sppg::whereIn('code', $sppgCodes)
                ->pluck('id')
                ->all();

            $school->sppgs()->syncWithoutDetaching($sppgIds);
        }
    }
}