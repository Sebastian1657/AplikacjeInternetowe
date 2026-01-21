<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

class Food extends Model implements Adminable
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = ['name', 'unit', 'stock_quantity'];
    public function dietPlans()
    {
        return $this->belongsToMany(DietPlan::class, 'diet_food')
                    ->withPivot('amount')
                    ->withTimestamps();
    }

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Magazyn Żywności',
            'fields' => [
                'name' => ['label' => 'Nazwa Produktu', 'type' => 'text'],
                'unit' => ['label' => 'Jednostka (kg/szt/g)', 'type' => 'text'],
                'stock_quantity' => ['label' => 'Stan Magazynowy', 'type' => 'number'],
            ]
        ];
    }
}
