<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'father_name',
        'mother_name',
        'father_surname',
        'mother_surname',
        'phone',
        'specialty',
        'status',
    ];

    public function setFatherNameAttribute(string $value): void
    {
        $this->attributes['father_name'] = strtoupper($value);
    }

    public function setMotherNameAttribute(string $value): void
    {
        $this->attributes['mother_name'] = strtoupper($value);
    }

    public function setFatherSurnameAttribute(string $value): void
    {
        $this->attributes['father_surname'] = strtoupper($value);
    }

    public function setMotherSurnameAttribute(string $value): void
    {
        $this->attributes['mother_surname'] = strtoupper($value);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function __toString(): string
    {
        return "{$this->father_name} {$this->father_surname} {$this->mother_surname}";
    }
}