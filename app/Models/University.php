<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class University extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'university';
    protected $fillable = [
        'name',
        'city',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'university_id');
    }
}
