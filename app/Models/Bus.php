<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'name',
        'plate_number',
        'capacity',
        'facilities',
        'image',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getFacilitiesArrayAttribute(): array
    {
        return $this->facilities ? explode(',', $this->facilities) : [];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}