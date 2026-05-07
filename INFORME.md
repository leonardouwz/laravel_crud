# Sistema Médico - Proyecto Completo

## Laravel 11 + Filament v3 + MySQL 8.0 + Docker

---

## Índice

1. [Descripción del Proyecto](#1-descripción-del-proyecto)
2. [Tecnologías y Herramientas](#2-tecnologías-y-herramientas)
3. [Arquitectura del Sistema](#3-arquitectura-del-sistema)
4. [Estructura de la Base de Datos](#4-estructura-de-la-base-de-datos)
5. [Modelos Eloquent y Relaciones](#5-modelos-eloquent-y-relaciones)
6. [Reglas de Negocio Implementadas](#6-reglas-de-negocio-implementadas)
7. [Panel de Administración con Filament](#7-panel-de-administración-con-filament)
8. [Instalación Paso a Paso](#8-instalación-paso-a-paso)
9. [Datos de Prueba](#9-datos-de-prueba)
10. [Capturas del Sistema](#10-capturas-del-sistema)
11. [Comandos Importantes](#11-comandos-importantes)
12. [Diagrama Entidad-Relación](#12-diagrama-entidad-relación)
13. [Cumplimiento de Requisitos](#13-cumplimiento-de-requisitos)

---

## 1. Descripción del Proyecto

El **Sistema Médico** es una aplicación web completa diseñada para la gestión integral de una clínica médica. El sistema permite administrar pacientes, doctores, historias clínicas, citas médicas y recetas electrónicas, todo respaldado por una base de datos robusta y un panel de administración moderno.

### Objetivos del Proyecto

- **Gestión de Pacientes**: Registro completo de pacientes con datos personales, información de contacto y notas médicas.
- **Administración de Doctores**: Control del staff médico incluyendo especialidades y datos de contacto.
- **Historias Clínicas**: Creación y mantenimiento de historias clínicas asociadas a cada paciente.
- **Programación de Citas**: Sistema de citas que relaciona pacientes con doctores específicos.
- **Recetas Médicas**: Generación de recetas electrónicas vinculadas a las citas médicas.
- **Validaciones de Negocio**: Reglas específicas que garantizan la integridad de los datos médicos.

### Características Principales

- Interfaz de administración moderna y responsive gracias a Filament v3
- Base de datos MySQL 8.0 con estructura optimizada
- Contenedores Docker para fácil despliegue
- Transformación automática de datos (mayúsculas)
- Validaciones de negocio específicas
- Datos de prueba realistas para demostración

---

## 2. Tecnologías y Herramientas

### 2.1 Backend

| Componente | Tecnología | Versión | Descripción |
|------------|-------------|---------|-------------|
| Framework | Laravel | 11.x | Framework PHP moderno y robusto |
| ORM | Eloquent | - | Mapeo objeto-relacional de Laravel |
| Lenguaje | PHP | 8.2 | Última versión LTS de PHP |
| Servidor Web | Apache | 2.4 | Servidor HTTP incluido en el contenedor |

### 2.2 Base de Datos

| Componente | Tecnología | Versión | Descripción |
|------------|-------------|---------|-------------|
| Motor | MySQL | 8.0 | Sistema de gestión de base de datos relacional |
| Herramienta Admin | phpMyAdmin | Latest | Interface web para administración de BD |

### 2.3 Contenedores

| Contenedor | Imagen | Propósito |
|------------|--------|-----------|
| medical_app | PHP 8.2 + Apache | Aplicación Laravel |
| medical_db | MySQL 8.0 | Base de datos |
| medical_phpmyadmin | phpMyAdmin | Administración de BD |

### 2.4 Panel de Administración

| Componente | Tecnología | Descripción |
|------------|-------------|-------------|
| Panel Admin | Filament | v3 - Panel administrativo para Laravel |
| UI Components | Tailwind CSS | Framework CSS para estilos |

---

## 3. Arquitectura del Sistema

### 3.1 Diagrama de Arquitectura

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           ARQUITECTURA DEL SISTEMA                        │
└─────────────────────────────────────────────────────────────────────────┘

                              ┌─────────────────┐
                              │   USUARIO       │
                              │   FINAL         │
                              └────────┬────────┘
                                       │
                                       ▼
                              ┌─────────────────┐
                              │   NAVEGADOR     │
                              │   WEB           │
                              └────────┬────────┘
                                       │ HTTP/HTTPS
                                       ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                         DOCKER COMPOSE                                  │
│                                                                         │
│   ┌───────────────────┐  ┌───────────────────┐  ┌───────────────────┐  │
│   │   medical_app     │  │    medical_db     │  │ medical_phpmyadmin │  │
│   │───────────────────│  │───────────────────│  │───────────────────│  │
│   │  PHP 8.2          │  │   MySQL 8.0       │  │   phpMyAdmin      │  │
│   │  Apache           │  │                   │  │                   │  │
│   │  Laravel 11       │  │   Port: 3306      │  │   Port: 8080      │  │
│   │  Filament v3      │  │                   │  │                   │  │
│   │                   │  │                   │  │                   │  │
│   │  Port: 8000       │  │                   │  │                   │  │
│   └───────────────────┘  └───────────────────┘  └───────────────────┘  │
│           │                      │                        │              │
│           └──────────────────────┴────────────────────────┘              │
│                                  │                                      │
│                           Volume Compartido                              │
└─────────────────────────────────────────────────────────────────────────┘
```

### 3.2 Estructura de Directorios

```
medical-system/
│
├── docker/                          # Configuración de contenedores
│   └── Dockerfile                  # Imagen personalizada PHP 8.2 + Apache
│
├── docker-compose.yml              # Orquestación de servicios Docker
│
├── .env.example                    # Plantilla de variables de entorno
│
├── .gitignore                      # Archivos ignorados por Git
│
├── README.md                       # Documentación del proyecto
│
└── src/                            # Código fuente de la aplicación
    │
    ├── app/                        # Núcleo de la aplicación Laravel
    │   │
    │   ├── Console/
    │   │   └── Commands/
    │   │       └── GenerateDER.php    # Comando artesanal para generar DER
    │   │
    │   ├── Filament/
    │   │   └── Resources/
    │   │       ├── PatientResource.php        # Recurso de Pacientes
    │   │       ├── DoctorResource.php         # Recurso de Doctores
    │   │       ├── ClinicalHistoryResource.php # Recurso de Historias Clínicas
    │   │       ├── AppointmentResource.php    # Recurso de Citas
    │   │       └── PrescriptionResource.php   # Recurso de Recetas
    │   │
    │   ├── Models/
    │   │   ├── Patient.php             # Modelo de Paciente
    │   │   ├── Doctor.php              # Modelo de Doctor
    │   │   ├── ClinicalHistory.php    # Modelo de Historia Clínica
    │   │   ├── Appointment.php         # Modelo de Cita
    │   │   └── Prescription.php       # Modelo de Receta
    │   │
    │   └── Providers/
    │       ├── AppServiceProvider.php        # Proveedor de servicios
    │       └── FilamentServiceProvider.php   # Proveedor de Filament
    │
    ├── bootstrap/                   # Bootstrap de Laravel
    │   ├── app.php                   # Configuración de la aplicación
    │   └── providers.php              # Proveedores de servicios
    │
    ├── config/                      # Archivos de configuración
    │   ├── app.php                   # Configuración de la app
    │   ├── database.php               # Configuración de BD
    │   ├── filesystems.php            # Configuración de archivos
    │   └── logging.php                # Configuración de logs
    │
    ├── database/
    │   ├── migrations/                # Migraciones de base de datos
    │   │   ├── 2024_01_01_000001_create_patients_table.php
    │   │   ├── 2024_01_01_000002_create_doctors_table.php
    │   │   ├── 2024_01_01_000003_create_clinical_histories_table.php
    │   │   ├── 2024_01_01_000004_create_appointments_table.php
    │   │   └── 2024_01_01_000005_create_prescriptions_table.php
    │   │
    │   └── seeders/                   # Seeders para datos de prueba
    │       ├── DatabaseSeeder.php
    │       ├── PatientSeeder.php
    │       ├── DoctorSeeder.php
    │       ├── ClinicalHistorySeeder.php
    │       ├── AppointmentSeeder.php
    │       └── PrescriptionSeeder.php
    │
    ├── public/                      # Punto de entrada público
    │   ├── index.php                 # Front controller
    │   ├── .htaccess                 # Configuración de Apache
    │   └── web.config                # Configuración IIS
    │
    ├── routes/                      # Definición de rutas
    │   ├── web.php                   # Rutas web
    │   └── console.php                # Rutas de consola
    │
    ├── storage/                     # Almacenamiento de Laravel
    │   ├── app/                      # Archivos de la aplicación
    │   ├── framework/
    │   │   ├── cache/                # Caché de la框架
    │   │   ├── sessions/             # Sesiones
    │   │   └── views/                # Vistas compiladas
    │   └── logs/                     # Archivos de log
    │
    ├── artisan                      # Binario de Laravel
    │
    ├── composer.json                # Dependencias de Composer
    │
    └── .env.example                  # Variables de entorno ejemplo
```

---

## 4. Estructura de la Base de Datos

### 4.1 Tabla: patients (Pacientes)

| Campo | Tipo | Nulo | Descripción |
|-------|------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | No | Identificador único del paciente |
| names | VARCHAR(255) | No | Nombres del paciente |
| father_surname | VARCHAR(255) | No | Apellido paterno |
| mother_surname | VARCHAR(255) | No | Apellido materno |
| dni | VARCHAR(20) | No | Número de DNI (único) |
| birth_date | DATE | No | Fecha de nacimiento |
| gender | VARCHAR(1) | No | Género (M o F) |
| address | TEXT | Sí | Dirección del paciente |
| phone | VARCHAR(20) | Sí | Número de teléfono |
| note | TEXT | Sí | Notas adicionales |
| created | DATETIME | No | Fecha de creación del registro |
| modified | DATETIME | No | Fecha de última modificación |
| status | INT | No | Estado (1=activo, 0=inactivo) |

### 4.2 Tabla: doctors (Doctores)

| Campo | Tipo | Nulo | Descripción |
|-------|------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | No | Identificador único del doctor |
| father_name | VARCHAR(255) | No | Nombre paterno |
| mother_name | VARCHAR(255) | No | Nombre materno |
| father_surname | VARCHAR(255) | No | Apellido paterno |
| mother_surname | VARCHAR(255) | No | Apellido materno |
| phone | VARCHAR(20) | Sí | Número de teléfono |
| specialty | VARCHAR(255) | No | Especialidad médica |
| created | DATETIME | No | Fecha de creación del registro |
| modified | DATETIME | No | Fecha de última modificación |
| status | INT | No | Estado del doctor |

### 4.3 Tabla: clinical_histories (Historias Clínicas)

| Campo | Tipo | Nulo | Descripción |
|-------|------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | No | Identificador único de la historia |
| patient_id | INT (FK) | No | Referencia al paciente (único) |
| allergies | TEXT | Sí | Alergias conocidas del paciente |
| created | DATETIME | No | Fecha de creación |
| modified | DATETIME | No | Fecha de última modificación |
| status | INT | No | Estado de la historia clínica |

**Clave Única**: patient_id debe ser único (un paciente tiene una sola historia clínica)

### 4.4 Tabla: appointments (Citas)

| Campo | Tipo | Nulo | Descripción |
|-------|------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | No | Identificador único de la cita |
| clinical_history_id | INT (FK) | No | Referencia a historia clínica |
| doctor_id | INT (FK) | No | Referencia al doctor |
| appointment_date | DATETIME | No | Fecha y hora de la cita |
| reason | TEXT | No | Razón de la consulta |
| diagnosis | TEXT | Sí | Diagnóstico médico |
| treatment | TEXT | Sí | Tratamiento prescrito |
| created | DATETIME | No | Fecha de creación |
| modified | DATETIME | No | Fecha de última modificación |
| status | INT | No | Estado de la cita |

### 4.5 Tabla: prescriptions (Recetas)

| Campo | Tipo | Nulo | Descripción |
|-------|------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | No | Identificador único de la receta |
| appointment_id | INT (FK) | No | Referencia a la cita |
| medication | VARCHAR(255) | No | Nombre del medicamento |
| dosage | VARCHAR(255) | No | Dosis prescrita |
| duration | VARCHAR(255) | No | Duración del tratamiento |
| created | DATETIME | No | Fecha de creación |
| modified | DATETIME | No | Fecha de última modificación |
| status | INT | No | Estado de la receta |

---

## 5. Modelos Eloquent y Relaciones

### 5.1 Modelo Patient

```php
class Patient extends Model
{
    protected $table = 'patients';

    // Relación uno a uno con ClinicalHistory
    public function clinicalHistory(): HasOne
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    // Transformación automática a mayúsculas
    protected static function booted(): void
    {
        static::saving(function (Patient $patient) {
            $patient->names = mb_strtoupper($patient->names);
            $patient->father_surname = mb_strtoupper($patient->father_surname);
            $patient->mother_surname = mb_strtoupper($patient->mother_surname);
        });
    }
}
```

### 5.2 Modelo Doctor

```php
class Doctor extends Model
{
    protected $table = 'doctors';

    // Relación uno a muchos con appointments
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Transformación automática a mayúsculas
    protected static function booted(): void
    {
        static::saving(function (Doctor $doctor) {
            $doctor->father_name = mb_strtoupper($doctor->father_name);
            $doctor->mother_name = mb_strtoupper($doctor->mother_name);
            $doctor->father_surname = mb_strtoupper($doctor->father_surname);
            $doctor->mother_surname = mb_strtoupper($doctor->mother_surname);
        });
    }
}
```

### 5.3 Modelo ClinicalHistory

```php
class ClinicalHistory extends Model
{
    protected $table = 'clinical_histories';

    // Relación belongsTo con Patient
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // Relación uno a muchos con Appointments
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
```

### 5.4 Modelo Appointment

```php
class Appointment extends Model
{
    protected $table = 'appointments';

    // Relación belongsTo con ClinicalHistory
    public function clinicalHistory(): BelongsTo
    {
        return $this->belongsTo(ClinicalHistory::class);
    }

    // Relación belongsTo con Doctor
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relación uno a muchos con Prescriptions
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
}
```

### 5.5 Modelo Prescription

```php
class Prescription extends Model
{
    protected $table = 'prescriptions';

    // Relación belongsTo con Appointment
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    // Validación: No permitir penicilina para cita ID=3
    protected static function booted(): void
    {
        static::creating(function (Prescription $prescription) {
            if ($prescription->appointment_id == 3 &&
                stripos($prescription->medication, 'penicilina') !== false) {
                throw ValidationException::withMessages([
                    'medication' => 'No se permite prescribir penicilina para la cita con id=3',
                ]);
            }
        });
    }
}
```

### 5.6 Diagrama de Relaciones

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                         RELACIONES ELOQUENT                                   │
└──────────────────────────────────────────────────────────────────────────────┘

  PATIENT                    CLINICAL_HISTORY                DOCTOR
  ┌─────────┐                ┌──────────────────┐           ┌─────────────┐
  │Patient  │                │ClinicalHistory   │           │Doctor       │
  └────┬────┘                └────────┬─────────┘           └──────┬──────┘
       │                              │                            │
       │ 1:1                          │ 1:N                       │ 1:N
       │                              │                            │
       │◄───────────────belongsTo     │◄─────────────belongsTo     │
       │                 │            │                 │          │
       │hasOne───────────┘            │hasMany─────────┘          │
       │                              │                            │
       │                              │         ┌─────────────────┘
       │                              │         │
       │                              ▼         ▼
       │                   ┌─────────────────────────┐
       │                   │     APPOINTMENT         │
       │                   ├─────────────────────────┤
       │                   │appointment_date        │
       │                   │reason                  │
       │                   │diagnosis                │
       │                   │treatment                │
       │                   └────────────┬───────────┘
       │                              │ 1:N
       │                              │
       │                    ┌────────┴──────────┐
       │                    │                   │
       │                    ▼                   │
       │            ┌──────────────┐           │
       │            │Prescription │           │
       │            ├──────────────┤           │
       │            │medication   │           │
       │            │dosage        │           │
       │            │duration     │           │
       │            └──────────────┘           │
```

---

## 6. Reglas de Negocio Implementadas

### 6.1 Unicidad del DNI

**Descripción**: El campo DNI en la tabla patients debe ser único a nivel de base de datos y modelo Laravel.

**Implementación**:
- En la migración: `$table->string('dni')->unique();`
- En el modelo Filament: `->unique(ignoreRecord: true)`

**Comportamiento**: El sistema impedirá registrar dos pacientes con el mismo DNI, mostrando un mensaje de error claro al usuario.

### 6.2 Transformación Automática a Mayúsculas

**Descripción**: Los campos de nombres en Patient y Doctor deben guardarse siempre en mayúsculas.

**Campos afectados**:

| Modelo | Campos Transformados |
|--------|---------------------|
| Patient | names, father_surname, mother_surname |
| Doctor | father_name, mother_name, father_surname, mother_surname |

**Implementación**: Se utiliza el método `booted()` en el modelo Eloquent con el hook `saving()` para transformar automáticamente los valores antes de guardarlos.

**Ejemplo**:
```php
$patient->names = mb_strtoupper($patient->names);
```

### 6.3 Validación de Prescripción - Restricción de Penicilina

**Descripción**: No se permite crear una receta médica si la cita tiene ID=3 y el medicamento contiene la palabra "penicilina" (case-insensitive).

**Justificación**: El paciente asociado a la cita ID=3 tiene alergia documentada a la penicilina. Esta restricción protege la salud del paciente evitando prescripciones potencialmente peligrosas.

**Implementación en el modelo Prescription**:

```php
protected static function booted(): void
{
    static::creating(function (Prescription $prescription) {
        if ($prescription->appointment_id == 3 &&
            stripos($prescription->medication, 'penicilina') !== false) {
            throw ValidationException::withMessages([
                'medication' => 'No se permite prescribir penicilina para la cita con id=3',
            ]);
        }
    });
}
```

**Comportamiento**: Cuando un usuario intenta crear una receta con "penicilina" para la cita ID=3, el sistema mostrará un mensaje de error sin permitir el registro.

---

## 7. Panel de Administración con Filament

### 7.1 Recursos Filament Creados

| Recurso | Ruta | Descripción |
|---------|------|-------------|
| PatientResource | /admin/patients | Gestión de pacientes |
| DoctorResource | /admin/doctors | Gestión de doctores |
| ClinicalHistoryResource | /admin/clinical-histories | Gestión de historias clínicas |
| AppointmentResource | /admin/appointments | Gestión de citas |
| PrescriptionResource | /admin/prescriptions | Gestión de recetas |

### 7.2 Características de Cada Recurso

**Formularios**:
- Todos los campos de la tabla correspondiente
- Selectores para claves foráneas (FK)
- Validaciones de entrada
- Transformación visual de datos

**Tablas de Listado**:
- Columnas principales visibles
- Badges de estado con colores
- Filtros por estado
- Acciones de edición y eliminación

**Operaciones**:
- Crear nuevos registros
- Editar registros existentes
- Eliminar registros
- Acciones en lote

---

## 8. Instalación Paso a Paso

### 8.1 Requisitos Previos

- Docker Engine instalado
- Docker Compose instalado
- Puerto 8000 disponible (aplicación)
- Puerto 8080 disponible (phpMyAdmin)

### 8.2 Paso 1: Clonar el Proyecto

```bash
git clone <repository-url> medical-system
cd medical-system
```

### 8.3 Paso 2: Configurar Variables de Entorno

```bash
cp src/.env.example src/.env
```

### 8.4 Paso 3: Construir Contenedores

```bash
docker-compose build
```

Este comando construirá la imagen Docker personalizada con PHP 8.2 y Apache.

### 8.5 Paso 4: Iniciar Servicios

```bash
docker-compose up -d
```

Verificar que todos los contenedores estén corriendo:

```bash
docker-compose ps
```

Deberías ver:
- medical_app    | running
- medical_db    | running
- medical_phpmyadmin | running

### 8.6 Paso 5: Configurar Aplicación Laravel

```bash
# Entrar al contenedor de la aplicación
docker exec -it medical_app bash

# Instalar dependencias de Composer
composer install

# Generar clave de aplicación Laravel
php artisan key:generate

# Ejecutar migraciones de base de datos
php artisan migrate

# Poblar base de datos con datos de prueba
php artisan db:seed

# Crear usuario administrador de Filament
php artisan make:filament-user
# Sigue las instrucciones para crear email y contraseña

# Generar documentación DER
php artisan app:der
```

### 8.7 Paso 6: Acceder al Sistema

| Servicio | URL |
|----------|-----|
| Panel Filament | http://localhost:8000/admin |
| phpMyAdmin | http://localhost:8080 |

---

## 9. Datos de Prueba

### 9.1 Pacientes (5 registros)

| ID | Nombres | Apellidos | DNI | Género |
|----|---------|-----------|-----|--------|
| 1 | JUAN CARLOS | GARCÍA LÓPEZ | 12345678 | M |
| 2 | MARÍA ELENA | RODRÍGUEZ VEGA | 23456789 | F |
| 3 | CARLOS ALBERTO | MARTÍNEZ SÁNCHEZ | 34567890 | M |
| 4 | ANA PATRICIA | FERNÁNDEZ RUIZ | 45678901 | F |
| 5 | ROBERTO CARLOS | TORRES FLORES | 56789012 | M |

### 9.2 Doctores (3 registros)

| ID | Nombres | Apellidos | Especialidad |
|----|---------|-----------|--------------|
| 1 | LUIS ALBERTO PÉREZ VARGAS | Dr. | Medicina General |
| 2 | CARMEN ROSA SOTO MORALES | Dra. | Pediatría |
| 3 | JORGE EDUARDO RAMÍREZ QUINTANA | Dr. | Cardiología |

### 9.3 Historias Clínicas (5 registros)

Cada historia clínica está asociada a un paciente específico.

| ID | Paciente | Alergias |
|----|----------|----------|
| 1 | JUAN CARLOS GARCÍA | Ninguna |
| 2 | MARÍA ELENA RODRÍGUEZ | - |
| 3 | CARLOS ALBERTO MARTÍNEZ | **Alérgico a penicilina** |
| 4 | ANA PATRICIA FERNÁNDEZ | Alérgico al ibuprofeno |
| 5 | ROBERTO CARLOS TORRES | - |

### 9.4 Citas (10 registros)

Distribución entre pacientes y doctores con diversos diagnósticos.

| ID | Paciente | Doctor | Fecha | Diagnóstico |
|----|----------|--------|-------|-------------|
| 1 | JC García | Dr. Pérez | 2024-05-10 | Hipertensión controlada |
| 2 | ME Rodríguez | Dra. Soto | 2024-05-11 | Gastritis aguda |
| 3 | **CA Martínez** | Dr. Pérez | 2024-05-12 | Paciente estable |
| 4 | AP Fernández | Dr. Ramírez | 2024-05-13 | Diabetes tipo 2 controlada |
| 5 | RC Torres | Dra. Soto | 2024-05-14 | Faringitis bacteriana |
| 6 | JC García | Dr. Ramírez | 2024-05-15 | Molestia muscular |
| 7 | ME Rodríguez | Dr. Pérez | 2024-05-16 | Recuperación satisfactoria |
| 8 | CA Martínez | Dra. Soto | 2024-05-17 | Vacunas al día |
| 9 | AP Fernández | Dr. Pérez | 2024-05-18 | Glucosa controlada |
| 10 | RC Torres | Dr. Ramírez | 2024-05-19 | Faringitis resuelta |

### 9.5 Recetas (7 registros)

Incluyendo una receta para probar la restricción de penicilina.

| ID | Cita | Medicamento | Dosis |
|----|------|-------------|-------|
| 1 | 1 | Enalapril 10mg | 1 tableta cada 12h |
| 2 | 2 | Omeprazol 20mg | 1 cápsula en ayunas |
| 3 | 3 | Vitamina C 500mg | 1 tableta diaria |
| 4 | 4 | Metformina 500mg | 1 tableta cada 12h |
| 5 | 4 | Glucofage 850mg | 1 tableta al día |
| 6 | 5 | Amoxicilina 500mg | 1 cápsula cada 8h |
| 7 | 5 | Paracetamol 500mg | 1 tableta si hay fiebre |

### 9.6 Caso de Prueba: Restricción de Penicilina

**Paciente**: CARLOS ALBERTO MARTÍNEZ SÁNCHEZ (ID=3)
**Alergia**: Alérgico a la penicilina y derivados
**Cita**: ID=3 (fecha: 2024-05-12)

Este paciente tiene una alergia documentada a la penicilina. La cita ID=3 está asociada a este paciente. Al intentar crear una receta con medicamento que contenga "penicilina" para esta cita, el sistema mostrará un mensaje de error: **"No se permite prescribir penicilina para la cita con id=3"**.

---

## 10. Capturas del Sistema

### 10.1 Pantalla de Login

```
╔═══════════════════════════════════════════════════════════════════════╗
║                         FILAMENT LOGIN                               ║
╠═══════════════════════════════════════════════════════════════════════╣
║                                                                       ║
║                        [ Logo del Sistema ]                          ║
║                        Sistema Médico                               ║
║                                                                       ║
║   ┌─────────────────────────────────────────────────────────────┐    ║
║   │  Correo electrónico                                        │    ║
║   │  ┌───────────────────────────────────────────────────────┐ │    ║
║   │  │ admin@medical-system.com                             │ │    ║
║   │  └───────────────────────────────────────────────────────┘ │    ║
║   └─────────────────────────────────────────────────────────────┘    ║
║                                                                       ║
║   ┌─────────────────────────────────────────────────────────────┐    ║
║   │  Contraseña                                                │    ║
║   │  ┌───────────────────────────────────────────────────────┐ │    ║
║   │  │ •••••••••••••••••••                                   │ │    ║
║   │  └───────────────────────────────────────────────────────┘ │    ║
║   └─────────────────────────────────────────────────────────────┘    ║
║                                                                       ║
║                    [   Iniciar Sesión   ]                            ║
║                                                                       ║
╚═══════════════════════════════════════════════════════════════════════╝
```

### 10.2 Listado de Pacientes

```
╔═══════════════════════════════════════════════════════════════════════════════╗
║                           GESTIÓN DE PACIENTES                               ║
╠═══════════════════════════════════════════════════════════════════════════════╣
║  [+ Nuevo Paciente]                    🔍 Buscar         [Estado: Todos ▼]  ║
╠═════╦═══════════╦═════════════╦═════════════╦═════════╦════════╦═══════════╣
║ ID  ║ Nombres   ║ A. Paterno  ║ A. Materno   ║ DNI     ║ Género  ║ Estado    ║
╠═════╬═══════════╬═════════════╬═════════════╬═════════╬════════╬═══════════╣
║  1  ║ JUAN      ║ GARCÍA      ║ LÓPEZ        ║12345678 ║ M      ║  ● Activo ║
╠═════╬═══════════╬═════════════╬═════════════╬═════════╬════════╬═══════════╣
║  2  ║ MARÍA     ║ RODRÍGUEZ   ║ VEGA         ║23456789 ║ F      ║  ● Activo ║
╠═════╬═══════════╬═════════════╬═════════════╬═════════╬════════╬═══════════╣
║  3  ║ CARLOS    ║ MARTÍNEZ    ║ SÁNCHEZ      ║34567890 ║ M      ║  ● Activo ║
╠═════╬═══════════╬═════════════╬═════════════╬═════════╬════════╬═══════════╣
║  4  ║ ANA       ║ FERNÁNDEZ   ║ RUIZ         ║45678901 ║ F      ║  ● Activo ║
╠═════╬═══════════╬═════════════╬═════════════╬═════════╬════════╬═══════════╣
║  5  ║ ROBERTO   ║ TORRES      ║ FLORES       ║56789012 ║ M      ║  ● Activo ║
╚═════╩═══════════╩═════════════╩═════════════╩═════════╩════════╩═══════════╝
║                      Mostrando 1-5 de 5 resultados                      ║
╚═══════════════════════════════════════════════════════════════════════════════╝
```

### 10.3 Formulario de Crear Cita

```
╔═══════════════════════════════════════════════════════════════════════════════╗
║                          CREAR NUEVA CITA                                    ║
╠═══════════════════════════════════════════════════════════════════════════════╣
║                                                                       ║
║  Historia Clínica *                                                    ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [Seleccionar historia clínica                              ▼] │  ║
║  │ ┌─────────────────────────────────────────────────────────────┐│  ║
║  │ │ JUAN CARLOS GARCÍA LÓPEZ - 12345678                       ││  ║
║  │ │ MARÍA ELENA RODRÍGUEZ VEGA - 23456789                     ││  ║
║  │ │ CARLOS ALBERTO MARTÍNEZ SÁNCHEZ - 34567890               ││  ║
║  │ │ ANA PATRICIA FERNÁNDEZ RUIZ - 45678901                   ││  ║
║  │ │ ROBERTO CARLOS TORRES FLORES - 56789012                   ││  ║
║  │ └─────────────────────────────────────────────────────────────┘│  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Doctor *                                                              ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [Seleccionar doctor                                         ▼] │  ║
║  │ ┌─────────────────────────────────────────────────────────────┐│  ║
║  │ │ Dr. LUIS ALBERTO PÉREZ - Medicina General                  ││  ║
║  │ │ Dra. CARMEN ROSA SOTO - Pediatría                         ││  ║
║  │ │ Dr. JORGE EDUARDO RAMÍREZ - Cardiología                   ││  ║
║  │ └─────────────────────────────────────────────────────────────┘│  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Fecha y Hora de Cita *                                                ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [📅 2024-05-20 09:00                                         ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Razón de la Consulta *                                                ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [                                                           ] │  ║
║  │ [Control de rutina                                           ] │  ║
║  │ [                                                           ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Diagnóstico (opcional)                                                 ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [                                                           ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Tratamiento (opcional)                                                ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [                                                           ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║                    [Cancelar]          [Crear Cita]                    ║
║                                                                       ║
╚═══════════════════════════════════════════════════════════════════════════════╝
```

### 10.4 Error de Validación - Penicilina

```
╔═══════════════════════════════════════════════════════════════════════════════╗
║                          CREAR NUEVA RECETA                                    ║
╠═══════════════════════════════════════════════════════════════════════════════╣
║                                                                       ║
║  Cita *                                                                 ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [3 - CARLOS ALBERTO MARTÍNEZ (2024-05-12)                 ▼] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Medicamento *                                                        ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [Penicilina 500mg                                            ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  ⚠ Error de validación                                                ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ ⚠ No se permite prescribir penicilina para la cita con id=3    │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Dosis *                                                              ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [                                                           ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║  Duración *                                                           ║
║  ┌─────────────────────────────────────────────────────────────────┐  ║
║  │ [                                                           ] │  ║
║  └─────────────────────────────────────────────────────────────────┘  ║
║                                                                       ║
║                    [Cancelar]          [Crear Receta]                  ║
║                                                                       ║
╚═══════════════════════════════════════════════════════════════════════════════╝
```

---

## 11. Comandos Importantes

### 11.1 Comandos Docker

```bash
# Construir imágenes Docker
docker-compose build

# Iniciar servicios
docker-compose up -d

# Detener servicios
docker-compose down

# Ver estado de servicios
docker-compose ps

# Ver logs de un servicio
docker-compose logs -f medical_app
docker-compose logs -f medical_db

# Reiniciar un servicio
docker-compose restart medical_app
```

### 11.2 Comandos Laravel Artisan

```bash
# Help de artisan
php artisan --help

# Ver todas las rutas registradas
php artisan route:list

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate
php artisan migrate:rollback

# Poblar base de datos
php artisan db:seed

# Crear usuario Filament
php artisan make:filament-user

# Generar documentación DER
php artisan app:der
```

### 11.3 Comandos MySQL

```bash
# Conectar a MySQL
docker exec -it medical_db mysql -umedical_user -psecret medical_db

# Ver todas las tablas
SHOW TABLES;

# Ver estructura de una tabla
DESCRIBE patients;

# Ver datos de una tabla
SELECT * FROM patients;
```

---

## 12. Diagrama Entidad-Relación

### 12.1 Representación Gráfica ASCII

```
╔═══════════════════════════════════════════════════════════════════════════════╗
║                  DIAGRAMA ENTIDAD-RELACIÓN (DER)                               ║
╚═══════════════════════════════════════════════════════════════════════════════╝


┌─────────────────┐         ┌─────────────────────────────────┐         ┌─────────────────────┐
│    PATIENTS     │         │      CLINICAL_HISTORIES          │         │       DOCTORS       │
│─────────────────│         │─────────────────────────────────│         │─────────────────────│
│ PK │ id          │1       1│ PK │ id                         │1       N│ PK │ id               │
│    │ names       ├────────┤ FK │ patient_id (UNIQUE)       ├─────────│    │ father_name       │
│    │ father_sn   │         │    │ allergies                 │         │    │ mother_name       │
│    │ mother_sn   │         │    │ created                  │         │    │ father_surname    │
│    │ dni (UNIQUE)│         │    │ modified                 │         │    │ mother_surname    │
│    │ birth_date  │         │    │ status                   │         │    │ phone             │
│    │ gender      │         └─────────────┬───────────────┘         │    │ specialty         │
│    │ address     │                       │                         │    │ created           │
│    │ phone       │                       │                         │    │ modified          │
│    │ note        │                       │                         │    │ status            │
│    │ created     │                       │                         └──────────┬──────────────┘
│    │ modified    │                       │                                  │
│    │ status      │                       │                                  │
└─────────────────┘                       │                                  │
                                          │                                  │
                                          │         ┌────────────────────────┘
                                          │         │
                                          │         │
                                 ┌────────┴─────────┴─────────┐
                                 │                           │
                                 │      APPOINTMENTS         │
                                 │───────────────────────────│
                                 │ PK │ id                   │
                                 │ FK │ clinical_history_id   │
                                 │ FK │ doctor_id            │
                                 │    │ appointment_date     │
                                 │    │ reason               │
                                 │    │ diagnosis            │
                                 │    │ treatment            │
                                 │    │ created              │
                                 │    │ modified             │
                                 │    │ status               │
                                 └────────────┬───────────────┘
                                              │
                                              │ 1:N
                                              │
                                 ┌────────────┴────────────┐
                                 │                         │
                                 │    PRESCRIPTIONS        │
                                 │─────────────────────────│
                                 │ PK │ id                 │
                                 │ FK │ appointment_id     │
                                 │    │ medication        │
                                 │    │ dosage             │
                                 │    │ duration           │
                                 │    │ created            │
                                 │    │ modified           │
                                 │    │ status             │
                                 └─────────────────────────┘
```

### 12.2 Leyenda de Cardinalidades

| Símbolo | Significado |
|---------|-------------|
| 1 | Uno |
| N | Muchos |
| PK | Primary Key (Clave Primaria) |
| FK | Foreign Key (Clave Foránea) |

### 12.3 Tipos de Relaciones

| Relación | Tipo | Descripción |
|----------|------|-------------|
| Patient ↔ ClinicalHistory | 1:1 | Un paciente tiene una historia clínica única |
| ClinicalHistory → Appointment | 1:N | Una historia puede tener muchas citas |
| Doctor → Appointment | 1:N | Un doctor puede tener muchas citas |
| Appointment → Prescription | 1:N | Una cita puede tener muchas recetas |

---

## 13. Cumplimiento de Requisitos

| # | Requisito | Estado | Descripción |
|---|-----------|--------|-------------|
| 1 | Docker + PHP 8.2 + Apache | ✅ | Dockerfile y docker-compose.yml |
| 2 | MySQL 8.0 | ✅ | Contenedor medical_db |
| 3 | Laravel 11 | ✅ | composer.json |
| 4 | Filament v3 | ✅ | Dependencias en composer.json |
| 5 | 5 tablas con campos específicos | ✅ | migrations/ |
| 6 | Timestamps created/modified | ✅ | Configurados en modelos |
| 7 | Relaciones Eloquent | ✅ | hasOne, hasMany, belongsTo |
| 8 | DNI único | ✅ | Unique en migración |
| 9 | Transformación MAYÚSCULAS | ✅ | booted() en modelos |
| 10 | Validación penicilina | ✅ | boot() en Prescription |
| 11 | 5 Recursos Filament | ✅ | Resources/ |
| 12 | Formularios completos | ✅ | Todos los campos |
| 13 | Selects para FK | ✅ | Relationship en Forms |
| 14 | Seeders con datos | ✅ | 5 pacientes, 3 doctores, etc. |
| 15 | Caso prueba penicilina | ✅ | Paciente ID=3 |
| 16 | Comando DER | ✅ | php artisan app:der |
| 17 | README.md | ✅ | Documentación completa |
| 18 | Acceso /admin | ✅ | Panel en /admin |

---

## Conclusión

El Sistema Médico ha sido desarrollado siguiendo las mejores prácticas de Laravel y Filament, implementando todas las reglas de negocio especificadas y cumpliendo con cada requisito del proyecto. El sistema está completamente containerizado con Docker, lo que facilita su despliegue en cualquier entorno.

### Información de Contacto

Para más información sobre el proyecto, consulte la documentación en código fuente o ejecute:

```bash
docker exec -it medical_app php artisan app:der
```

---

**Autor**: Sistema Médico - Proyecto Educativo
**Versión**: 1.0
**Fecha**: 2024
