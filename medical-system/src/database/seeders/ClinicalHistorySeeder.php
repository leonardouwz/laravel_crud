<?php

namespace Database\Seeders;

use App\Models\ClinicalHistory;
use Illuminate\Database\Seeder;

class ClinicalHistorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $histories = [
            [
                'patient_id' => 1,
                'allergies' => 'Ninguna alergia conocida',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'patient_id' => 2,
                'allergies' => null,
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'patient_id' => 3,
                'allergies' => 'Alérgico a la penicilina y derivados',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'patient_id' => 4,
                'allergies' => 'Alérgico al ibuprofeno',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'patient_id' => 5,
                'allergies' => null,
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
        ];

        foreach ($histories as $historyData) {
            ClinicalHistory::create($historyData);
        }
    }
}