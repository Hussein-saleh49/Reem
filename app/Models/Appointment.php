<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'appointment_time',
        'is_skipped',
        'measuremnt_id',
    ];

    protected $casts = [
        'appointment_time' => 'datetime',
        'is_skipped' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class);  // Define the relationship
    }
}
