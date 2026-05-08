<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $patients = [
            [
                'names' => 'Juan Carlos',
                'father_surname' => 'García',
                'mother_surname' => 'López',
                'dni' => '12345678',
                'birth_date' => '1985-03-15',
                'gender' => 'M',
                'address' => 'Av. Arequipa 1234, Lima',
                'phone' => '987654321',
                'note' => 'Paciente con hipertensión controlada',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'names' => 'María Elena',
                'father_surname' => 'Rodríguez',
                'mother_surname' => 'Vega',
                'dni' => '23456789',
                'birth_date' => '1990-07-22',
                'gender' => 'F',
                'address' => 'Calle Los Olivos 456, Miraflores',
                'phone' => '998877665',
                'note' => null,
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'names' => 'Carlos Alberto',
                'father_surname' => 'Martínez',
                'mother_surname' => 'Sánchez',
                'dni' => '34567890',
                'birth_date' => '1978-11-08',
                'gender' => 'M',
                'address' => 'Jr. Amazonas 789, San Juan de Lurigancho',
                'phone' => '976543210',
                'note' => 'Alérgico a la penicilina',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'names' => 'Ana Patricia',
                'father_surname' => 'Fernández',
                'mother_surname' => 'Ruiz',
                'dni' => '45678901',
                'birth_date' => '1995-01-30',
                'gender' => 'F',
                'address' => 'Av. Benavides 2345, Santiago de Surco',
                'phone' => '965432109',
                'note' => 'Paciente diabética tipo 2',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'names' => 'Roberto Carlos',
                'father_surname' => 'Torres',
                'mother_surname' => 'Flores',
                'dni' => '56789012',
                'birth_date' => '1982-09-12',
                'gender' => 'M',
                'address' => 'Calle Las Flores 678, La Molina',
                'phone' => '954321098',
                'note' => null,
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
        ];

        foreach ($patients as $patientData) {
            $patientData['names'] = mb_strtoupper($patientData['names']);
            $patientData['father_surname'] = mb_strtoupper($patientData['father_surname']);
            $patientData['mother_surname'] = mb_strtoupper($patientData['mother_surname']);
            Patient::create($patientData);
        }
    }
}