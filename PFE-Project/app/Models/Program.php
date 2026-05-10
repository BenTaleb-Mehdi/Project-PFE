<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['created_by_staff_id', 'title'];

    public function staff()
    {
        return $this->belongsTo(User::class, 'created_by_staff_id');
    }

    public function items()
    {
        return $this->hasMany(ProgramItem::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
