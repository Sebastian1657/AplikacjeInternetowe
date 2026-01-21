<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

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

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Plany Żywieniowe',
            'fields' => [
                'name' => ['label' => 'Nazwa Diety', 'type' => 'text'],
                'feeding_frequency' => ['label' => 'Częstotliwość', 'type' => 'text'],
            ]
        ];
    }
}
