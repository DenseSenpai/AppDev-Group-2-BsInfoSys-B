<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarder_id',
        'type',
        'amount',
        'period_start',
        'period_end',
        'is_auto_generated',
        'is_paid',
    ];

    public function boarder()
    {
        return $this->belongsTo(Boarder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
