<?php

namespace Database\Seeders;

use App\Models\Prescription;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $prescriptions = [
            // Cita 1 (ID=1)
            [
                'appointment_id' => 1,
                'medication' => 'Enalapril 10mg',
                'dosage' => '1 tableta cada 12 horas',
                'duration' => '30 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            // Cita 2 (ID=2)
            [
                'appointment_id' => 2,
                'medication' => 'Omeprazol 20mg',
                'dosage' => '1 cápsula en ayunas',
                'duration' => '14 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            // Cita 3 (ID=3) - Esta cita tiene paciente alérgico a penicilina
            [
                'appointment_id' => 3,
                'medication' => 'Vitamina C 500mg',
                'dosage' => '1 tableta diaria',
                'duration' => '30 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            // Cita 4 (ID=4)
            [
                'appointment_id' => 4,
                'medication' => 'Metformina 500mg',
                'dosage' => '1 tableta cada 12 horas',
                'duration' => '90 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'appointment_id' => 4,
                'medication' => 'Glucofage 850mg',
                'dosage' => '1 tableta al día',
                'duration' => '90 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            // Cita 5 (ID=5)
            [
                'appointment_id' => 5,
                'medication' => 'Amoxicilina 500mg',
                'dosage' => '1 cápsula cada 8 horas',
                'duration' => '7 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'appointment_id' => 5,
                'medication' => 'Paracetamol 500mg',
                'dosage' => '1 tableta si hay fiebre',
                'duration' => '5 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
        ];

        foreach ($prescriptions as $prescriptionData) {
            Prescription::create($prescriptionData);
        }
    }
}