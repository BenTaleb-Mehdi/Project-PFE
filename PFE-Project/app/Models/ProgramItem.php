<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramItem extends Model
{
    protected $fillable = ['program_id', 'meal_id', 'day_of_week', 'time_slot'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
