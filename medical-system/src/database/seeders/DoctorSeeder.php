<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $doctors = [
            [
                'father_name' => 'Luis Alberto',
                'mother_name' => 'Miguel',
                'father_surname' => 'Pérez',
                'mother_surname' => 'Vargas',
                'phone' => '987123456',
                'specialty' => 'Medicina General',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'father_name' => 'Carmen Rosa',
                'mother_name' => 'Elena',
                'father_surname' => 'Soto',
                'mother_surname' => 'Morales',
                'phone' => '998234567',
                'specialty' => 'Pediatría',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'father_name' => 'Jorge Eduardo',
                'mother_name' => 'Antonio',
                'father_surname' => 'Ramírez',
                'mother_surname' => 'Quintana',
                'phone' => '999345678',
                'specialty' => 'Cardiología',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
        ];

        foreach ($doctors as $doctorData) {
            $doctorData['father_name'] = mb_strtoupper($doctorData['father_name']);
            $doctorData['mother_name'] = mb_strtoupper($doctorData['mother_name']);
            $doctorData['father_surname'] = mb_strtoupper($doctorData['father_surname']);
            $doctorData['mother_surname'] = mb_strtoupper($doctorData['mother_surname']);
            Doctor::create($doctorData);
        }
    }
}