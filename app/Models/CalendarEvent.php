<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'time',
        'location'
    ];

    protected $casts = [
        'event_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}