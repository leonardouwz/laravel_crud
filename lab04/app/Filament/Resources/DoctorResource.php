<?php

namespace App\Filament\Resources;

use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Doctores';
    protected static ?string $modelLabel = 'Doctor';
    protected static ?string $pluralModelLabel = 'Doctores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('father_name')->label('Nombre del Padre')->required()->maxLength(155),
                Forms\Components\TextInput::make('mother_name')->label('Nombre de la Madre')->required()->maxLength(155),
                Forms\Components\TextInput::make('father_surname')->label('Apellido Paterno')->required()->maxLength(155),
                Forms\Components\TextInput::make('mother_surname')->label('Apellido Materno')->required()->maxLength(155),
                Forms\Components\TextInput::make('phone')->label('Teléfono')->required()->maxLength(20),
                Forms\Components\TextInput::make('specialty')->label('Especialidad')->required()->maxLength(100),
                Forms\Components\Select::make('status')->label('Estado')->options([1 => 'Activo', 0 => 'Inactivo'])->default(1)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('father_name')->label('Nombres')->searchable(),
                Tables\Columns\TextColumn::make('father_surname')->label('Ap. Paterno')->searchable(),
                Tables\Columns\TextColumn::make('mother_surname')->label('Ap. Materno'),
                Tables\Columns\TextColumn::make('specialty')->label('Especialidad')->searchable(),
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}