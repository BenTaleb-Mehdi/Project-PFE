<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staffs extends Model
{
    protected $fillable = ['user_id', 'specialty', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'created_by_staff_id');
    }
}
