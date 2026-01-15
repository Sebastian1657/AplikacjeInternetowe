<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'unit', 'stock_quantity'];
    public function dietPlans()
    {
        return $this->belongsToMany(DietPlan::class, 'diet_food')
                    ->withPivot('amount')
                    ->withTimestamps();
    }
}
