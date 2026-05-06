<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\ClinicalHistory;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('TRUNCATE TABLE prescriptions;');
        DB::statement('TRUNCATE TABLE appointments;');
        DB::statement('TRUNCATE TABLE clinical_historys;');
        DB::statement('TRUNCATE TABLE patients;');
        DB::statement('TRUNCATE TABLE doctors;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $doctors = [
            [
                'father_name' => 'RICARDO',
                'mother_name' => 'BEATRIZ',
                'father_surname' => 'DIAZ',
                'mother_surname' => 'ASES',
                'phone' => '955544433',
                'specialty' => 'MEDICINA GENERAL',
                'status' => 1,
            ],
            [
                'father_name' => 'SARA',
                'mother_name' => 'LUCIA',
                'father_surname' => 'CASTRO',
                'mother_surname' => 'RUIZ',
                'phone' => '966533442',
                'specialty' => 'PEDIATRIA',
                'status' => 1,
            ],
            [
                'father_name' => 'CARLOS',
                'mother_name' => 'ANA',
                'father_surname' => 'MORALES',
                'mother_surname' => 'VEGA',
                'phone' => '977422331',
                'specialty' => 'CARDIOLOGIA',
                'status' => 1,
            ],
        ];

        $doctorIds = [];
        foreach ($doctors as $doctorData) {
            $doctor = Doctor::create($doctorData);
            $doctorIds[] = $doctor->id;
        }

        $patients = [
            [
                'names' => 'JUAN CARLOS',
                'father_surname' => 'PEREZ',
                'mother_surname' => 'GARCIA',
                'dni' => '12345678',
                'birth_date' => '1985-03-15',
                'gender' => 'M',
                'address' => 'AV. LARNA 123, BREÑA',
                'phone' => '987654321',
                'note' => 'Paciente con alergias',
                'status' => 1,
            ],
            [
                'names' => 'MARIA ELENA',
                'father_surname' => 'LOPEZ',
                'mother_surname' => 'MENDOZA',
                'dni' => '87654321',
                'birth_date' => '1990-07-22',
                'gender' => 'F',
                'address' => 'JR. AMEZ 456, MIRAFLORES',
                'phone' => '912345678',
                'note' => null,
                'status' => 1,
            ],
            [
                'names' => 'ROBERTO CARLOS',
                'father_surname' => 'RAMIREZ',
                'mother_surname' => 'TORRES',
                'dni' => '11223344',
                'birth_date' => '1978-11-08',
                'gender' => 'M',
                'address' => 'PLAZA MAYOR 789, CERCADO',
                'phone' => '998877665',
                'note' => 'Paciente diabético',
                'status' => 1,
            ],
        ];

        $patientIds = [];
        foreach ($patients as $patientData) {
            $patient = Patient::create($patientData);
            $patientIds[] = $patient->id;
        }

        $clinicalHistories = [
            [
                'patient_id' => $patientIds[0],
                'allergies' => 'PENICILINA, POLEN',
                'status' => 1,
            ],
            [
                'patient_id' => $patientIds[1],
                'allergies' => null,
                'status' => 1,
            ],
            [
                'patient_id' => $patientIds[2],
                'allergies' => 'ASPIRINA',
                'status' => 1,
            ],
        ];

        $clinicalHistoryIds = [];
        foreach ($clinicalHistories as $historyData) {
            $history = ClinicalHistory::create($historyData);
            $clinicalHistoryIds[] = $history->id;
        }

        $appointments = [
            [
                'clinical_history_id' => $clinicalHistoryIds[0],
                'doctor_id' => $doctorIds[0],
                'appointment_date' => '2025-09-25 09:30:00',
                'reason' => 'DOLOR DE CABEZA',
                'diagnosis' => 'CEFALEA TENSIONAL',
                'treatment' => 'PARACETAMOL 500MG CADA 8 HORAS',
                'status' => 1,
            ],
            [
                'clinical_history_id' => $clinicalHistoryIds[1],
                'doctor_id' => $doctorIds[1],
                'appointment_date' => '2025-09-26 10:00:00',
                'reason' => 'CONTROL DE PESO',
                'diagnosis' => 'SOBREPESO GRADO I',
                'treatment' => 'DIETA BALANCEADA + EJERCICIO',
                'status' => 1,
            ],
            [
                'clinical_history_id' => $clinicalHistoryIds[2],
                'doctor_id' => $doctorIds[2],
                'appointment_date' => '2025-09-27 11:00:00',
                'reason' => 'DOLOR TORACICO',
                'diagnosis' => 'ANGINA ESTABLE',
                'treatment' => 'NITROGLICERINA SUBLINGUAL',
                'status' => 1,
            ],
        ];

        $appointmentIds = [];
        foreach ($appointments as $appointmentData) {
            $appointment = Appointment::create($appointmentData);
            $appointmentIds[] = $appointment->id;
        }

        $prescriptions = [
            [
                'appointment_id' => $appointmentIds[0],
                'medication' => 'PARACETAMOL 500MG',
                'dosage' => '1 TABLETA CADA 8 HORAS',
                'duration' => '7 DÍAS',
                'status' => 1,
            ],
            [
                'appointment_id' => $appointmentIds[1],
                'medication' => 'OMET 20MG',
                'dosage' => '1 TABLETA EN AYUNAS',
                'duration' => '30 DÍAS',
                'status' => 1,
            ],
            [
                'appointment_id' => $appointmentIds[2],
                'medication' => 'NITROGLICERINA 0.4MG',
                'dosage' => '1 TABLETA SUBLINGUAL',
                'duration' => 'CUANDO DOLOR',
                'status' => 1,
            ],
            [
                'appointment_id' => $appointmentIds[2],
                'medication' => 'ASPIRINA 100MG',
                'dosage' => '1 TABLETA DIARIA',
                'duration' => 'CONTINUO',
                'status' => 1,
            ],
        ];

        foreach ($prescriptions as $prescriptionData) {
            Prescription::create($prescriptionData);
        }

        $this->command->info('Datos de ejemplo insertados correctamente.');
    }
}