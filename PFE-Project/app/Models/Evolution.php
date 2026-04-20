<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{
    protected $fillable = ['client_id', 'weight', 'body_img_url', 'recorded_at'];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
