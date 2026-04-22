<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilitySchedule extends Model
{
    protected $fillable = [
        'facility_id',
        'day_type',
        'open_time',
        'close_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}