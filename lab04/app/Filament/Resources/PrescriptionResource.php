<?php

namespace App\Filament\Resources;

use App\Models\Prescription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationLabel = 'Recetas';
    protected static ?string $modelLabel = 'Receta';
    protected static ?string $pluralModelLabel = 'Recetas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('appointment_id')
                    ->label('Cita')
                    ->relationship('appointment', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('medication')->label('Medicamento')->required()->maxLength(255),
                Forms\Components\TextInput::make('dosage')->label('Dosis')->required()->maxLength(100),
                Forms\Components\TextInput::make('duration')->label('Duración')->required()->maxLength(100),
                Forms\Components\Select::make('status')->label('Estado')->options([1 => 'Activo', 0 => 'Inactivo'])->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('appointment_id')->label('Cita ID'),
                Tables\Columns\TextColumn::make('medication')->label('Medicamento')->searchable(),
                Tables\Columns\TextColumn::make('dosage')->label('Dosis'),
                Tables\Columns\TextColumn::make('duration')->label('Duración'),
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
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
        ];
    }
}