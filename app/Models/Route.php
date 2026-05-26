<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'origin',
        'destination',
        'distance',
        'duration',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getFullRouteAttribute(): string
    {
        return $this->origin . ' → ' . $this->destination;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}