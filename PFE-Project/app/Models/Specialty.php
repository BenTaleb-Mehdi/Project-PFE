<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name'];

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'staff_specialty');
    }
}
