<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Internship extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'internships';
    protected $fillable = [
        'demand_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'date_fiche_fin_stage',
        'date_depot_rapport',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($internship) {
            $internship->updateStatusIfNeeded();
        });

        static::saving(function ($internship) {
            $internship->updateStatusIfNeeded(false);
        });
    }

    public function updateStatusIfNeeded($save = true)
    {
        $today = Carbon::today();

        if ($this->status !== 'terminated') {
            if ($today->lt(Carbon::parse($this->start_date))) {
                $this->status = 'pending';
            } elseif ($today->between(Carbon::parse($this->start_date), Carbon::parse($this->end_date))) {
                $this->status = 'active';
            } elseif ($today->gt(Carbon::parse($this->end_date))) {
                $this->status = 'finished';
            }
        }

        if ($save && $this->isDirty('status')) {
            $this->saveQuietly();
        }
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function absences()
    {
        return $this->hasMany(Absence::class, 'internship_id');
    }
}
