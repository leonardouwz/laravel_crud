<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $table = 'appointments';

    public $timestamps = false;

    protected $fillable = [
        'clinical_history_id',
        'doctor_id',
        'appointment_date',
        'reason',
        'diagnosis',
        'treatment',
        'created',
        'modified',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    public function clinicalHistory(): BelongsTo
    {
        return $this->belongsTo(ClinicalHistory::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
}