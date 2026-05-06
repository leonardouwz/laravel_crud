<?php

namespace App\Filament\Resources;

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
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('doctor_id')
                    ->label('Doctor')
                    ->relationship('doctor', 'father_surname')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('appointment_date')->label('Fecha y hora de la cita')->required(),
                Forms\Components\Textarea::make('reason')->label('Motivo de la consulta')->required(),
                Forms\Components\Textarea::make('diagnosis')->label('Diagnóstico')->required(),
                Forms\Components\Textarea::make('treatment')->label('Tratamiento indicado')->required(),
                Forms\Components\Select::make('status')->label('Estado')->options([1 => 'Activo', 0 => 'Inactivo'])->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('appointment_date')->label('Fecha')->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('doctor.father_surname')->label('Doctor')->searchable(),
                Tables\Columns\TextColumn::make('reason')->label('Motivo'),
                Tables\Columns\TextColumn::make('diagnosis')->label('Diagnóstico'),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}