# IW - Laboratorio 04: Laravel Admin con Docker y Filament

## Descripción
Este laboratorio implementa un sistema de gestión de historias clínicas médicas utilizando Laravel 11, FilamentPHP v3 y MySQL 8 en contenedores Docker.

## Estructura del Proyecto

```
lab04/
├── Dockerfile                    # Imagen PHP 8.2-FPM
├── docker-compose.yml          # Servicios: web, db, phpmyadmin
├── setup.sh                   # Script de inicialización automática
├── .gitignore
├── .env.example               # Variables de entorno
├── medical-app/               # Proyecto Laravel (se crea automáticamente)
├── app/
│   ├── Models/                # Modelos Eloquent
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   ├── ClinicalHistory.php
│   │   ├── Appointment.php
│   │   └── Prescription.php
│   ├── Filament/Resources/     # Resources de Filament
│   │   ├── PatientResource.php
│   │   ├── DoctorResource.php
│   │   ├── ClinicalHistoryResource.php
│   │   ├── AppointmentResource.php
│   │   └── PrescriptionResource.php
│   ├── Console/Commands/
│   │   └── CreateAdminUser.php
│   └── Providers/Filament/
│       └── AdminPanelProvider.php
└── database/
    ├── migrations/            # Migraciones
    └── seeders/               # Seeders
```

## Modelo de Datos

### Entidades

| Tabla | Descripción |
|-------|-------------|
| **Patients** | Información de pacientes (nombre, apellido, DNI, etc.) |
| **Doctors** | Información de médicos (especialidad, colegiatura) |
| **ClinicalHistories** | Historias clínicas vinculadas a pacientes |
| **Appointments** | Citas médicas |
| **Prescriptions** | Recetas emitidas en citas |

### Relaciones
- Un Patient tiene una ClinicalHistory (uno a uno)
- Una ClinicalHistory tiene muchos Appointments (uno a muchos)
- Un Doctor tiene muchos Appointments (uno a muchos)
- Un Appointment tiene muchas Prescriptions (uno a muchos)

---

## Uso con Docker

### 1. Construir y levantar contenedores

```bash
cd lab04
docker compose up --build -d
```

### 2. Esperar a que termine la configuración

El proceso incluye:
- Crear proyecto Laravel
- Instalar Filament
- Ejecutar migraciones
- Insertar datos de ejemplo
- Crear usuario admin
- Iniciar servidor

### 3. Acceder a la aplicación

- **URL**: http://localhost:8100/admin
- **Usuario**: admin@medical.com
- **Contraseña**: 1234

### 4. phpMyAdmin (opcional)

- **URL**: http://localhost:8080
- **Usuario**: laravel
- **Contraseña**: secret

---

## Persistencia de Datos

Los datos persisten en el volumen Docker `db_data`. Para **resetear**:

```bash
docker compose down -v          # Elimina volúmenes
docker compose up --build -d   # Recrear todo
```

---

## Credenciales del Administrador

- **Usuario**: `admin@medical.com`
- **Contraseña**: `1234`

---

## Características Implementadas

### Modelos
- **Mutators**: Conversión a mayúsculas para nombres
- **Relaciones Eloquent**: hasOne, hasMany, belongsTo
- **Validación personalizada**: Prescription no permite penicilina en cita ID=3

### Filament
- Panel de administración automático
- 5 Resources con formularios y tablas
- Relaciones ForeignKey con selectores

### Datos de Ejemplo
- 3 Patients
- 3 Doctors
- 3 Clinical Histories
- 3 Appointments
- 4 Prescriptions

---

## Comandos de Gestión de Docker

### Iniciar el contenedor
Para iniciar los contenedores en segundo plano:
```bash
docker compose up -d
```
*Nota: La primera vez o si hay cambios, usar `docker compose up --build -d`.*

### Parar el contenedor
Para detener los contenedores sin eliminarlos:
```bash
docker compose stop
```
Para volver a iniciarlos:
```bash
docker compose start
```

### Detener y eliminar contenedores
Para detener y eliminar los contenedores (pero manteniendo imágenes y volúmenes):
```bash
docker compose down
```

### Borrar todo (Limpieza total)
Para eliminar contenedores, imágenes y volúmenes asociados al proyecto:
```bash
docker compose down --rmi all -v
```

---

## Rúbrica de Calificación

| Ítem | Descripción | Puntaje |
| :--- | :--- | :---: |
| **Docker** | Implementación con contenedores | 3 |
| **Laravel** | Proyecto Laravel estructurado | 3 |
| **Modelos** | Modelos con mutators y relaciones | 3 |
| **Migraciones** | 5 tablas con foreign keys | 2 |
| **Filament** | Panel de administración completo | 3 |
| **Validación** | Validación personalizada | 2 |
| **Seeders** | Datos de ejemplo | 2 |
| **Automatización** | Setup.sh automatizado | 2 |
|  | **Total** | **20** |

---

## Autocalificación

| Ítem | Descripción | Puntaje | Estado |
| :--- | :--- | :---: | :---: |
| **Docker** | Implementación con contenedores | 3 | 3 |
| **Laravel** | Proyecto Laravel estructurado | 3 | 3 |
| **Modelos** | Modelos con mutators y relaciones | 3 | 3 |
| **Migraciones** | 5 tablas con foreign keys | 2 | 2 |
| **Filament** | Panel de administración completo | 3 | 3 |
| **Validación** | Validación personalizada | 2 | 2 |
| **Seeders** | Datos de ejemplo | 2 | 2 |
| **Automatización** | Setup.sh automatizado | 2 | 2 |
|  | **Total** | **20** | **20** |

*Laboratorio completado con todos los requisitos de la rúbrica.*

---

## Notas

- El proyecto Laravel se crea automáticamente durante el primer inicio
- Los datos persisten mientras no se elimine el volumen `db_data`
- La validación personalizada está en el método `boot()` de Prescription
- El volumen `db_data` funciona similar al `db.sqlite3` del Lab 04