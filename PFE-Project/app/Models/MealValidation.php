<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealValidation extends Model
{
    protected $fillable = [
        'client_id',
        'program_item_id',
        'validated_for'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function programItem()
    {
        return $this->belongsTo(ProgramItem::class);
    }
}
