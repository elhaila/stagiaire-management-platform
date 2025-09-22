<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Demande extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'demandes';
    protected $fillable = [
        'person_id',
        'university_id',
        'diplome_id',
        'type',
        'cv',
        'start_date',
        'end_date',
        'status',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Automatically check and update status when a demande is retrieved from database
        static::retrieved(function ($demande) {
            if ($demande->status === 'pending' && Carbon::parse($demande->end_date)->isPast()) {
                $demande->update(['status' => 'expired']);
            }
        });
    }

    public function person()
{
    return $this->belongsTo(Person::class, 'person_id');
}

public function university()
{
    return $this->belongsTo(University::class, 'university_id');
}

public function diplome()
{
    return $this->belongsTo(Diplome::class, 'diplome_id');
}


    public function internships()
    {
        return $this->hasMany(Internship::class, 'demand_id');
    }
}
