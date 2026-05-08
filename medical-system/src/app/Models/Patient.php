<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    protected $table = 'patients';

    public $timestamps = false;

    protected $fillable = [
        'names',
        'father_surname',
        'mother_surname',
        'dni',
        'birth_date',
        'gender',
        'address',
        'phone',
        'note',
        'created',
        'modified',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    public function clinicalHistory(): HasOne
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Patient $patient) {
            $patient->names = mb_strtoupper($patient->names);
            $patient->father_surname = mb_strtoupper($patient->father_surname);
            $patient->mother_surname = mb_strtoupper($patient->mother_surname);
        });
    }
}