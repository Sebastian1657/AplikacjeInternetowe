<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{

    protected $table = 'diet_plans';
    protected $fillable = ['name', 'feeding_frequency', 'instructions'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'diet_food')
                    ->withPivot('amount')
                    ->withTimestamps();
    }
}
