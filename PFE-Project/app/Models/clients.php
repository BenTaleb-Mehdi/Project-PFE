<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    protected $fillable = ['user_id', 'phone_number', 'status', 'target_goal', 'current_weight', 'height'];

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
}
