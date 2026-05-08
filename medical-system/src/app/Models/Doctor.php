<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $table = 'doctors';

    public $timestamps = false;

    protected $fillable = [
        'father_name',
        'mother_name',
        'father_surname',
        'mother_surname',
        'phone',
        'specialty',
        'created',
        'modified',
        'status',
    ];

    protected $casts = [
        'created' => 'datetime',
        'modified' => 'datetime',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Doctor $doctor) {
            $doctor->father_name = mb_strtoupper($doctor->father_name);
            $doctor->mother_name = mb_strtoupper($doctor->mother_name);
            $doctor->father_surname = mb_strtoupper($doctor->father_surname);
            $doctor->mother_surname = mb_strtoupper($doctor->mother_surname);
        });
    }
}