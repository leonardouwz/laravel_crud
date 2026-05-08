<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDER extends Command
{
    protected $signature = 'app:der';

    protected $description = 'Genera documentación del Diagrama Entidad-Relación';

    public function handle(): int
    {
        $der = <<<EOT
================================================================================
DIAGRAMA ENTIDAD-RELACIÓN - SISTEMA MÉDICO
================================================================================

TABLAS Y CAMPOS
--------------------------------------------------------------------------------

1. PATIENTS (Pacientes)
   PK: id (INT, AUTO_INCREMENT)
   - names (VARCHAR)
   - father_surname (VARCHAR)
   - mother_surname (VARCHAR)
   - dni (VARCHAR, UNIQUE)
   - birth_date (DATE)
   - gender (VARCHAR: M/F)
   - address (TEXT, NULL)
   - phone (VARCHAR, NULL)
   - note (TEXT, NULL)
   - created (DATETIME)
   - modified (DATETIME)
   - status (INT: 1=activo, 0=inactivo)

2. DOCTORS (Doctores)
   PK: id (INT, AUTO_INCREMENT)
   - father_name (VARCHAR)
   - mother_name (VARCHAR)
   - father_surname (VARCHAR)
   - mother_surname (VARCHAR)
   - phone (VARCHAR, NULL)
   - specialty (VARCHAR)
   - created (DATETIME)
   - modified (DATETIME)
   - status (INT)

3. CLINICAL_HISTORIES (Historias Clínicas)
   PK: id (INT, AUTO_INCREMENT)
   FK: patient_id (FK -> patients.id, UNIQUE)
   - allergies (TEXT, NULL)
   - created (DATETIME)
   - modified (DATETIME)
   - status (INT)

4. APPOINTMENTS (Citas)
   PK: id (INT, AUTO_INCREMENT)
   FK: clinical_history_id (FK -> clinical_histories.id)
   FK: doctor_id (FK -> doctors.id)
   - appointment_date (DATETIME)
   - reason (TEXT)
   - diagnosis (TEXT, NULL)
   - treatment (TEXT, NULL)
   - created (DATETIME)
   - modified (DATETIME)
   - status (INT)

5. PRESCRIPTIONS (Recetas)
   PK: id (INT, AUTO_INCREMENT)
   FK: appointment_id (FK -> appointments.id)
   - medication (VARCHAR)
   - dosage (VARCHAR)
   - duration (VARCHAR)
   - created (DATETIME)
   - modified (DATETIME)
   - status (INT)

================================================================================
RELACIONES
================================================================================

PATIENT (1) ────── (1) CLINICAL_HISTORY
  Uno a Uno (hasOne / belongsTo)
  Un paciente tiene una única historia clínica
  Una historia clínica pertenece a un único paciente

CLINICAL_HISTORY (1) ────── (N) APPOINTMENT
  Uno a Muchos (hasMany / belongsTo)
  Una historia clínica puede tener muchas citas
  Una cita pertenece a una única historia clínica

DOCTOR (1) ────── (N) APPOINTMENT
  Uno a Muchos (hasMany / belongsTo)
  Un doctor puede tener muchas citas
  Una cita pertenece a un único doctor

APPOINTMENT (1) ────── (N) PRESCRIPTION
  Uno a Muchos (hasMany / belongsTo)
  Una cita puede tener muchas recetas
  Una receta pertenece a una única cita

================================================================================
RESTRICCIONES DE NEGOCIO
================================================================================

1. UNICIDAD
   - El campo 'dni' en la tabla patients debe ser único a nivel de BD y modelo

2. TRANSFORMACIÓN AUTOMÁTICA
   - Patient: names, father_surname, mother_surname → MAYÚSCULAS al guardar
   - Doctor: father_name, mother_name, father_surname, mother_surname → MAYÚSCULAS

3. VALIDACIÓN DE PRESCRIPCIÓN
   - No permitir crear Prescription si:
     * appointment_id == 3
     * Y medication contiene "penicilina" (case-insensitive)
   - En tal caso, lanzar ValidationException

================================================================================
DIAGRAMA ASCII
================================================================================

┌─────────────┐         ┌─────────────────────┐         ┌────────────────┐
│  PATIENTS   │         │ CLINICAL_HISTORIES   │         │   DOCTORS      │
│─────────────│         │─────────────────────│         │───────────────│
│ PK id       │1        | PK id               |     1   │ PK id         │
│ names       ├────────<│ FK patient_id (U)   │         │ father_name   │
│ father_sn   │         │ allergies            │         │ mother_name   │
│ mother_sn   │         │ created              │         │ father_surname│
│ dni (U)     │         │ modified             │         │ mother_surname│
│ birth_date  │         │ status               │         │ phone         │
│ gender      │         └─────────┬───────────┘         │ specialty     │
│ address     │                   │                      │ created       │
│ phone       │                   │                      │ modified      │
│ note        │                   │                      │ status        │
│ created     │                   │                      └────────┬───────┘
│ modified    │                   │                               │
│ status      │                   │                               │
└─────────────┘                   │                               │
                                 │                               │
                                 │         ┌───────────────────────┘
                                 │         │
                                 │         │
                          ┌──────┴────────┴───────┐
                          │                        │
                          │    APPOINTMENTS       │
                          │────────────────────────│
                          │ PK id                  │
                          │ FK clinical_history_id │
                          │ FK doctor_id           │
                          │ appointment_date       │
                          │ reason                 │
                          │ diagnosis              │
                          │ treatment              │
                          │ created                │
                          │ modified               │
                          │ status                 │
                          └───────────┬────────────┘
                                      │
                                      │ 1:N
                                      │
                          ┌───────────┴───────────┐
                          │                       │
                          │   PRESCRIPTIONS       │
                          │───────────────────────│
                          │ PK id                 │
                          │ FK appointment_id     │
                          │ medication           │
                          │ dosage                │
                          │ duration              │
                          │ created               │
                          │ modified              │
                          │ status                │
                          └───────────────────────┘

================================================================================
EOT;

        $this->line($der);

        $outputPath = base_path('DER.md');
        file_put_contents($outputPath, $der);

        $this->info("Diagrama DER guardado en: {$outputPath}");

        return Command::SUCCESS;
    }
}