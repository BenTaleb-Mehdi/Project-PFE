<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';
    protected $fillable = ['user_id', 'specialty', 'bio', 'phone_number', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'staff_specialty');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'user_id', 'user_id'); // Temporary assumption: linked by user if no coach_id
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'created_by_staff_id');
    }
}
