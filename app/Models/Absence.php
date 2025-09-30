<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Absence extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'absences';
    protected $fillable = [
        'internship_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'justification',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }
}
