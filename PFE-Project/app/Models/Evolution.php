<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{
    protected $fillable = ['client_id', 'weight', 'images', 'recorded_at'];

    protected $casts = [
        'images' => 'array',
        'recorded_at' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

