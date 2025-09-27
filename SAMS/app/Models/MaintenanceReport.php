<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarder_id',
        'room_id',
        'category',
        'description',
        'media',
        'status',
        'assigned_to',
    ];

    protected $casts = [
        'media' => 'array', // auto-handle JSON
    ];

    public function boarder()
    {
        return $this->belongsTo(Boarder::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
