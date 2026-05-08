<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class Prescription extends Model
{
    protected $table = 'prescriptions';

    public $timestamps = false;

    protected $fillable = [
        'appointment_id',
        'medication',
        'dosage',
        'duration',
        'created',
        'modified',
        'status',
    ];

    protected $casts = [
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Prescription $prescription) {
            if ($prescription->appointment_id == 3 && stripos($prescription->medication, 'penicilina') !== false) {
                throw ValidationException::withMessages([
                    'medication' => 'No se permite prescribir penicilina para la cita con id=3',
                ]);
            }
        });
    }
}