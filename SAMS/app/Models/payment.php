<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarder_id',
        'room_id',      // ✅ added this
        'bill_id',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function boarder()
    {
        return $this->belongsTo(Boarder::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    
}
