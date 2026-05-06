<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

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
        'status',
    ];

    public function setNamesAttribute(string $value): void
    {
        $this->attributes['names'] = strtoupper($value);
    }

    public function setFatherSurnameAttribute(string $value): void
    {
        $this->attributes['father_surname'] = strtoupper($value);
    }

    public function setMotherSurnameAttribute(string $value): void
    {
        $this->attributes['mother_surname'] = strtoupper($value);
    }

    public function clinicalHistory()
    {
        return $this->hasOne(ClinicalHistory::class);
    }

    public function __toString(): string
    {
        return "{$this->names} {$this->father_surname} {$this->mother_surname}";
    }
}