<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Resources\PatientResource;
use App\Filament\Resources\DoctorResource;
use App\Filament\Resources\ClinicalHistoryResource;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\PrescriptionResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->resources([
                PatientResource::class,
                DoctorResource::class,
                ClinicalHistoryResource::class,
                AppointmentResource::class,
                PrescriptionResource::class,
            ])
            ->widgets([]);
    }
}