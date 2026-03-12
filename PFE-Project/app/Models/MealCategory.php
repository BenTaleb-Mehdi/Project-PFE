<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealCategory extends Model
{
    protected $fillable = ['name'];

    public function meals()
    {
        return $this->hasMany(Meal::class, 'category_id');
    }
}
