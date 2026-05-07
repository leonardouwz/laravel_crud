<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinical_history_id',
        'doctor_id',
        'appointment_date',
        'reason',
        'diagnosis',
        'treatment',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function clinicalHistory()
    {
        return $this->belongsTo(ClinicalHistory::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}