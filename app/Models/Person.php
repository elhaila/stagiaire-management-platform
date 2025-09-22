<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
     protected $table = 'people'; 
    protected $fillable = [
        'fullname',
        'cin',
        'email',
        'phone',
    ];

    // One person can submit many demandes
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    // Get all internships through demandes
    public function internships()
    {
        return $this->hasManyThrough(Internship::class, Demande::class, 'person_id', 'demand_id');
    }

    // Get all absences through internships
    public function absences()
    {
        return $this->hasManyThrough(Absence::class, Internship::class, 'demand_id', 'internship_id')
                    ->join('demandes', 'internships.demand_id', '=', 'demandes.id')
                    ->where('demandes.person_id', $this->id);
    }
}
