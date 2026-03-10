<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
