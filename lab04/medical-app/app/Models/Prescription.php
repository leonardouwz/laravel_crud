<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\ValidationException;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'medication',
        'dosage',
        'duration',
        'status',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Prescription $prescription) {
            if (
                $prescription->appointment_id == 3 &&
                str_contains(strtolower($prescription->medication), 'penicilina')
            ) {
                throw ValidationException::withMessages([
                    'medication' => 'No se puede recetar penicilina para la cita con ID 3.',
                ]);
            }
        });
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}