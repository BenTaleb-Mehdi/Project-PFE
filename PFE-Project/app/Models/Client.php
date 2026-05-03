<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id', 
        'phone_number', 
        'status', 
        'target_goal', 
        'current_weight', 
        'height',
        'program_id',
        'program_started_at',
        'duration_weeks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evolutions()
    {
        return $this->hasMany(Evolution::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the program deadline date.
     */
    public function getDeadlineAttribute()
    {
        if (!$this->program_started_at) return null;
        return \Carbon\Carbon::parse($this->program_started_at)->addWeeks($this->duration_weeks ?? 12);
    }

    /**
     * Get days remaining until program deadline.
     */
    public function getDaysLeftAttribute()
    {
        $deadline = $this->deadline;
        if (!$deadline) return null;
        return (int) now()->diffInDays($deadline, false);
    }
}
