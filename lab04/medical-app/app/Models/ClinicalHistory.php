<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicalHistory extends Model
{
    use HasFactory;

    protected $table = 'clinical_historys';

    protected $fillable = [
        'patient_id',
        'allergies',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}