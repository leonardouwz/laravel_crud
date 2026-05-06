<?php

namespace App\Filament\Resources;

use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Pacientes';
    protected static ?string $modelLabel = 'Paciente';
    protected static ?string $pluralModelLabel = 'Pacientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('names')->label('Nombres')->required()->maxLength(155),
                Forms\Components\TextInput::make('father_surname')->label('Apellido Paterno')->required()->maxLength(155),
                Forms\Components\TextInput::make('mother_surname')->label('Apellido Materno')->required()->maxLength(155),
                Forms\Components\TextInput::make('dni')->label('DNI')->required()->unique(ignoreRecord: true)->maxLength(20),
                Forms\Components\DatePicker::make('birth_date')->label('Fecha de Nacimiento')->required(),
                Forms\Components\Select::make('gender')->label('Género')->options(['M' => 'Masculino', 'F' => 'Femenino'])->required(),
                Forms\Components\Textarea::make('address')->label('Dirección')->required(),
                Forms\Components\TextInput::make('phone')->label('Teléfono')->required()->maxLength(20),
                Forms\Components\Textarea::make('note')->label('Notas')->nullable(),
                Forms\Components\Select::make('status')->label('Estado')->options([1 => 'Activo', 0 => 'Inactivo'])->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dni')->label('DNI')->searchable(),
                Tables\Columns\TextColumn::make('names')->label('Nombres')->searchable(),
                Tables\Columns\TextColumn::make('father_surname')->label('Ap. Paterno'),
                Tables\Columns\TextColumn::make('mother_surname')->label('Ap. Materno'),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}