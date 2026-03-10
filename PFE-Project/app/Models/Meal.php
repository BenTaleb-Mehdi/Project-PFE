<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['category_id', 'name', 'details', 'protein', 'carbs', 'fats', 'calories'];

    public function category()
    {
        return $this->belongsTo(MealCategory::class, 'category_id');
    }

    public function programItems()
    {
        return $this->hasMany(ProgramItem::class);
    }
}
