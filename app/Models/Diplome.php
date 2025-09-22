<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Diplome extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'diplomes';
    protected $fillable = [
        'name'
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'diplome_id');
    }
}
