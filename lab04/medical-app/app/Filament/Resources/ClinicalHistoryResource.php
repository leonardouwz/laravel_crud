<?php

namespace App\Filament\Resources;

use App\Models\ClinicalHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClinicalHistoryResource extends Resource
{
    protected static ?string $model = ClinicalHistory::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Historias Clínicas';
    protected static ?string $modelLabel = 'Historia Clínica';
    protected static ?string $pluralModelLabel = 'Historias Clínicas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->label('Paciente')
                    ->relationship('patient', 'names')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Textarea::make('allergies')->label('Alergias')->nullable(),
                Forms\Components\Select::make('status')->label('Estado')->options([1 => 'Activo', 0 => 'Inactivo'])->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('patient.names')->label('Paciente')->searchable(),
                Tables\Columns\TextColumn::make('allergies')->label('Alergias')->searchable(),
                Tables\Columns\BadgeColumn::make('status')->label('Estado')->colors(['success' => 1, 'danger' => 0]),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ListClinicalHistories::route('/'),
            // 'create' => Pages\CreateClinicalHistory::route('/create'),
            // 'edit' => Pages\EditClinicalHistory::route('/{record}/edit'),
        ];
    }
}