<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',
        'capacity',
        'monthly_rent',
        'vacant_slots',
    ];

    // Relationships
    // In Room.php
public function boarders()
{
    return $this->hasMany(Boarder::class);
}

// In Boarder.php
public function room()
{
    return $this->belongsTo(Room::class);
}


    // Accessors (use vacant_slots as the source of truth)
    public function getAvailableSlotsAttribute()
    {
        return (int)$this->vacant_slots;
    }

    public function getIsAvailableAttribute()
    {
        return $this->vacant_slots > 0;
    }
}
