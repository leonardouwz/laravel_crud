<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $appointments = [
            [
                'clinical_history_id' => 1,
                'doctor_id' => 1,
                'appointment_date' => '2024-05-10 09:00:00',
                'reason' => 'Control de presión arterial',
                'diagnosis' => 'Hipertensión arterial en control',
                'treatment' => 'Continuar con los medicamentos actuales',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 2,
                'doctor_id' => 2,
                'appointment_date' => '2024-05-11 10:30:00',
                'reason' => 'Dolor abdominal',
                'diagnosis' => 'Gastritis aguda',
                'treatment' => 'Omeprazol 20mg por 14 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 3,
                'doctor_id' => 1,
                'appointment_date' => '2024-05-12 08:00:00',
                'reason' => 'Chequeo general',
                'diagnosis' => 'Paciente estable',
                'treatment' => 'Revisión en 3 meses',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 4,
                'doctor_id' => 3,
                'appointment_date' => '2024-05-13 11:00:00',
                'reason' => 'Control de glucosa',
                'diagnosis' => 'Diabetes tipo 2 controlada',
                'treatment' => 'Metformina 500mg дважды al día',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 5,
                'doctor_id' => 2,
                'appointment_date' => '2024-05-14 14:00:00',
                'reason' => 'Fiebre y dolor de garganta',
                'diagnosis' => 'Faringitis bacteriana',
                'treatment' => 'Amoxicilina 500mg cada 8 horas por 7 días',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 1,
                'doctor_id' => 3,
                'appointment_date' => '2024-05-15 09:30:00',
                'reason' => 'Dolor en el pecho',
                'diagnosis' => 'Molestia muscular',
                'treatment' => 'Ibuprofeno 400mg según necesidad',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 2,
                'doctor_id' => 1,
                'appointment_date' => '2024-05-16 10:00:00',
                'reason' => 'Seguimiento gastroenteritis',
                'diagnosis' => 'Recuperación satisfactoria',
                'treatment' => 'Dieta blanda por una semana',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 3,
                'doctor_id' => 2,
                'appointment_date' => '2024-05-17 08:30:00',
                'reason' => 'Vacunación',
                'diagnosis' => 'Vacunas al día',
                'treatment' => null,
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 4,
                'doctor_id' => 1,
                'appointment_date' => '2024-05-18 11:30:00',
                'reason' => 'Revisión de análisis',
                'diagnosis' => 'Glucosa controlada',
                'treatment' => 'Continuar con dieta y ejercicio',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
            [
                'clinical_history_id' => 5,
                'doctor_id' => 3,
                'appointment_date' => '2024-05-19 15:00:00',
                'reason' => 'Control post-tratamiento',
                'diagnosis' => 'Faringitis resuelta',
                'treatment' => 'Alta médica',
                'created' => $now,
                'modified' => $now,
                'status' => 1,
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }
    }
}