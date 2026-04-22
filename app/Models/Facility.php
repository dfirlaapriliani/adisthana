<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
        'capacity',
        'description',
        'status',
        'maintenance_note',
    ];

    public function schedules()
    {
        return $this->hasMany(FacilitySchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}