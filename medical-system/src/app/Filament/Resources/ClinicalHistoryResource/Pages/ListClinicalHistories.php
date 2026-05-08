<?php

namespace App\Filament\Resources\ClinicalHistoryResource\Pages;

use App\Filament\Resources\ClinicalHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClinicalHistories extends ListRecords
{
    public static string $resource = ClinicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}