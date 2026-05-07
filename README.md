# Sistema Médico - Laravel + Filament

Sistema de gestión médica desarrollado con Laravel 11 y Filament v3.

## Estructura del Proyecto

```
medical-system/
├── docker/
│   └── Dockerfile                 # Imagen PHP 8.2 + Apache
├── docker-compose.yml             # Orquestación de servicios
├── .env.example                   # Variables de entorno ejemplo
├── .gitignore                     # Archivos ignorados por git
├── README.md                      # Este archivo
└── src/
    ├── app/
    │   ├── Console/
    │   │   └── Commands/
    │   │       └── GenerateDER.php     # Comando para generar DER
    │   ├── Filament/
    │   │   └── Resources/
    │   │       ├── PatientResource.php
    │   │       ├── DoctorResource.php
    │   │       ├── ClinicalHistoryResource.php
    │   │       ├── AppointmentResource.php
    │   │       └── PrescriptionResource.php
    │   ├── Models/
    │   │   ├── Patient.php
    │   │   ├── Doctor.php
    │   │   ├── ClinicalHistory.php
    │   │   ├── Appointment.php
    │   │   └── Prescription.php
    │   └── Providers/
    │       ├── AppServiceProvider.php
    │       └── FilamentServiceProvider.php
    ├── bootstrap/
    │   ├── app.php
    │   └── providers.php
    ├── config/
    │   ├── app.php
    │   ├── database.php
    │   ├── filesystems.php
    │   └── logging.php
    ├── database/
    │   ├── migrations/
    │   │   ├── 2024_01_01_000001_create_patients_table.php
    │   │   ├── 2024_01_01_000002_create_doctors_table.php
    │   │   ├── 2024_01_01_000003_create_clinical_histories_table.php
    │   │   ├── 2024_01_01_000004_create_appointments_table.php
    │   │   └── 2024_01_01_000005_create_prescriptions_table.php
    │   └── seeders/
    │       ├── DatabaseSeeder.php
    │       ├── PatientSeeder.php
    │       ├── DoctorSeeder.php
    │       ├── ClinicalHistorySeeder.php
    │       ├── AppointmentSeeder.php
    │       └── PrescriptionSeeder.php
    ├── public/
    │   ├── index.php
    │   ├── .htaccess
    │   └── web.config
    ├── routes/
    │   ├── console.php
    │   └── web.php
    ├── storage/
    │   ├── app/
    │   ├── framework/
    │   │   ├── cache/
    │   │   ├── sessions/
    │   │   └── views/
    │   └── logs/
    ├── artisan
    └── composer.json
```

## Requisitos

- Docker y Docker Compose instalados
- Puerto 8000 disponible (app)
- Puerto 8080 disponible (phpMyAdmin)

## Pasos de Instalación

### 1. Clonar o crear el proyecto

```bash
git clone <repository-url> medical-system
cd medical-system
```

### 2. Configurar variables de entorno

```bash
cp src/.env.example src/.env
```

### 3. Construir e iniciar los contenedores

```bash
docker-compose build
docker-compose up -d
```

### 4. Esperar a que MySQL esté listo y configurar la aplicación

```bash
# Verificar que los contenedores están corriendo
docker-compose ps

# Entrar al contenedor de la aplicación
docker exec -it medical_app bash

# Dentro del contenedor, ejecutar:
composer install

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Poblar la base de datos
php artisan db:seed

# Crear usuario administrador de Filament
php artisan make:filament-user

# Generar documentación DER
php artisan app:der
```

### 5. Acceder al sistema

- **Panel de Administración Filament**: http://localhost:8000/admin
- **phpMyAdmin**: http://localhost:8080

## Comandos Útiles dentro del Contenedor

```bash
# Help de artisan
php artisan --help

# Ver rutas
php artisan route:list

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Regenerar DER
php artisan app:der

# Ver tablas en BD
docker exec -it medical_db mysql -umedical_user -psecret medical_db -e "SHOW TABLES;"
```

## Datos Iniciales

El sistema viene con datos de prueba:

- **5 Pacientes**: Juan García, María Rodríguez, Carlos Martínez, Ana Fernández, Roberto Torres
- **3 Doctores**: Dr. Pérez, Dra. Soto, Dr. Ramírez
- **5 Historias Clínicas**: Una por cada paciente
- **10 Citas**: Con diagnósticos y tratamientos
- **7 Recetas**: Distribuidas en las citas

### Caso de Prueba para Restricción

La cita con **ID=3** tiene un paciente alérgico a la penicilina. Esta restricción está implementada en el modelo `Prescription` y se puede probar creando una receta para esta cita con un medicamento que contenga "penicilina".

## Capturas del Sistema

### Login de Filament

```
┌─────────────────────────────────────────────────────────────┐
│                  FILAMENT LOGIN                           │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│              [Logo del Sistema Médico]                     │
│                                                             │
│     ┌─────────────────────────────────────────────┐        │
│     │ Email:                                       │        │
│     │ [admin@medical-system.com____________]      │        │
│     └─────────────────────────────────────────────┘        │
│                                                             │
│     ┌─────────────────────────────────────────────┐        │
│     │ Password:                                   │        │
│     │ [•••••••••••••••••___________________]      │        │
│     └─────────────────────────────────────────────┘        │
│                                                             │
│            [    Iniciar Sesión    ]                        │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### Listado de Pacientes

```
┌───────────────────────────────────────────────────────────────────────┐
│                           PACIENTES                                  │
├─────┬───────────┬─────────────┬────────────┬─────────┬────────┬───────┤
│ ID  │ Nombres   │ A. Paterno   │ A. Materno │ DNI     │ Gén.   │Estado │
├─────┼───────────┼─────────────┼────────────┼─────────┼────────┼───────┤
│  1  │ JUAN      │ GARCÍA      │ LÓPEZ      │12345678 │ M      │Activo │
│  2  │ MARÍA     │ RODRÍGUEZ   │ VEGA       │23456789 │ F      │Activo │
│  3  │ CARLOS    │ MARTÍNEZ    │ SÁNCHEZ    │34567890 │ M      │Activo │
│  4  │ ANA       │ FERNÁNDEZ   │ RUIZ       │45678901 │ F      │Activo │
│  5  │ ROBERTO   │ TORRES      │ FLORES     │56789012 │ M      │Activo │
├─────┴───────────┴─────────────┴────────────┴─────────┴────────┴───────┤
│                          [ 5 resultados ]                            │
│                    [ + Nuevo Paciente ]                              │
└───────────────────────────────────────────────────────────────────────┘
```

### Crear Nueva Cita

```
┌─────────────────────────────────────────────────────────────────────┐
│                        CREAR CITA                                    │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  Historia Clínica *                                                 │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [JUAN CARLOS GARCÍA LÓPEZ - 12345678________________________▼] │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  Doctor *                                                           │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [Dr. LUIS ALBERTO PÉREZ - Medicina General__________________▼] │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  Fecha de Cita *                                                    │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [2024-05-20 09:00_________________________________________📅] │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  Razón *                                                            │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [Control de rutina_________________________________________] │   │
│  │ [__________________________________________________________] │   │
│  │ [__________________________________________________________] │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│                        [ Cancelar ]  [ Guardar ]                    │
└─────────────────────────────────────────────────────────────────────┘
```

### Error de Validación en Receta

```
┌─────────────────────────────────────────────────────────────────────┐
│                        CREAR RECETA                                  │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  Cita *                                                             │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [3 - JUAN CARLOS GARCÍA LÓPEZ (2024-05-12)_________________▼] │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  Medicamento *                                                      │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [Penicilina 500mg_________________________________________] │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ⚠ Error: No se permite prescribir penicilina para la cita con     │
│            id=3                                                     │
│                                                                     │
│  Dosis *                                                            │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │ [__________________________________________________________] │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│                        [ Cancelar ]  [ Guardar ]                    │
└─────────────────────────────────────────────────────────────────────┘
```

## Cumplimiento de Requisitos

| Requisito | Estado | Descripción |
|-----------|--------|-------------|
| Docker + PHP 8.2 + Apache | ✅ | docker/Dockerfile y docker-compose.yml |
| MySQL 8.0 | ✅ | Contenedor db en docker-compose |
| Laravel 11 | ✅ | src/composer.json |
| Filament v3 | ✅ | Dependencies en composer.json |
| 5 Tablas con campos específicos | ✅ | Todas las migraciones creadas |
| Timestamps (created/modified) | ✅ | Campos configurados en modelos |
| Relaciones Eloquent | ✅ | hasOne, hasMany, belongsTo en modelos |
| DNI único | ✅ | Unique en migración y validación |
| Transformación MAYÚSCULAS | ✅ | Boot model en Patient y Doctor |
| Validación penicilina | ✅ | boot() en Prescription model |
| 5 Recursos Filament | ✅ | Patient, Doctor, ClinicalHistory, Appointment, Prescription |
| Formularios con todos campos | ✅ | Todos los campos en cada Resource |
| Selects para FK | ✅ | Relation en formularios |
| Seeders con datos | ✅ | 5 pacientes, 3 doctores, 5 historias, 10 citas, 7 recetas |
| Caso prueba penicilina | ✅ | Paciente ID=3 con alergia |
| Comando DER | ✅ | php artisan app:der |
| README.md completo | ✅ | Este documento |
| Acceso /admin | ✅ | Filament configurado en /admin |

## Modelo de Datos (DER)

```
┌─────────────┐         ┌─────────────────────┐         ┌────────────────┐
│  PATIENTS   │ 1     1  │ CLINICAL_HISTORIES  │ 1     N │    DOCTORS     │
├─────────────┤├────────<├─────────────────────┤         ├────────────────┤
│ PK id       │         │ PK id               │         │ PK id          │
│ names       │         │ FK patient_id (U)   │         │ father_name    │
│ father_sn   │         │ allergies           │         │ mother_name    │
│ mother_sn   │         │ created             │         │ father_surname │
│ dni (UNIQUE)│         │ modified            │         │ mother_surname │
│ birth_date  │         │ status              │         │ specialty      │
│ gender      │         └─────────┬───────────┘         │ phone          │
│ address     │                   │                     │ created        │
│ phone       │                   │                     │ modified       │
│ note        │                   │                     │ status         │
└─────────────┘                   │                     └───────┬────────┘
                                 │                             │
                                 │         ┌───────────────────┘
                                 │         │
                          ┌──────┴────────┴───────┐
                          │    APPOINTMENTS       │
                          ├───────────────────────┤
                          │ PK id                 │
                          │ FK clinical_history_id│
                          │ FK doctor_id          │
                          │ appointment_date      │
                          │ reason                │
                          │ diagnosis             │
                          │ treatment             │
                          │ created               │
                          │ modified              │
                          │ status                │
                          └───────────┬───────────┘
                                      │
                                      │ 1:N
                          ┌───────────┴───────────┐
                          │   PRESCRIPTIONS      │
                          ├───────────────────────┤
                          │ PK id                 │
                          │ FK appointment_id    │
                          │ medication            │
                          │ dosage                │
                          │ duration              │
                          │ created               │
                          │ modified              │
                          │ status                │
                          └───────────────────────┘
```

## Licencia

Este proyecto es de uso educativo y académico.