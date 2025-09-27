<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boarder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'boarder_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'course',
        'year_level',
        'room_id',
        'move_in_date',
        'move_out_date',
        'emergency_contacts',
    ];

    protected $casts = [
        'emergency_contacts' => 'array',
        'move_in_date' => 'date',
        'move_out_date' => 'date',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(User::class); // each boarder belongs to one user (student account)
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    // 🔹 Auto-generate a rent bill when a boarder is created
   // app/Models/Boarder.php
protected static function booted()
{
    static::created(function ($boarder) {
        if ($boarder->room) {
            \App\Models\Bill::create([
                'boarder_id'        => $boarder->id,
                'type'              => 'rent',
                'amount'            => $boarder->room->monthly_rent,
                'period_start'      => now()->startOfMonth(),
                'period_end'        => now()->endOfMonth(),
                'is_auto_generated' => true,
                'is_paid'           => false,
            ]);
        }
    });
}

}
