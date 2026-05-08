<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Citas';
    protected static ?string $modelLabel = 'Cita';
    protected static ?string $pluralModelLabel = 'Citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('clinical_history_id')
                    ->label('Historia Clínica')
                    ->relationship('clinicalHistory', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient->names} - {$record->patient->dni}")
                    ->required(),
                Forms\Components\Select::make('doctor_id')
                    ->label('Doctor')
                    ->relationship('doctor', 'father_surname')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->father_name} {$record->father_surname} - {$record->specialty}")
                    ->required(),
                Forms\Components\DateTimePicker::make('appointment_date')
                    ->label('Fecha de Cita')
                    ->required(),
                Forms\Components\Textarea::make('reason')
                    ->label('Razón')
                    ->rows(3)
                    ->required(),
                Forms\Components\Textarea::make('diagnosis')
                    ->label('Diagnóstico')
                    ->rows(3),
                Forms\Components\Textarea::make('treatment')
                    ->label('Tratamiento')
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ])
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('appointment_date')->label('Fecha')->dateTime(),
                Tables\Columns\TextColumn::make('clinicalHistory.patient.names')->label('Paciente'),
                Tables\Columns\TextColumn::make('doctor.father_name')->label('Doctor'),
                Tables\Columns\TextColumn::make('reason')->label('Razón')->limit(50),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => 1,
                        'danger' => 0,
                    ])
                    ->formatStateUsing(fn (int $state) => $state === 1 ? 'Activo' : 'Inactivo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}