<?php

namespace App\Models;

use App\Interfaces\Adminable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model implements Adminable
{
    use HasFactory;

    protected $table = 'animals';

    protected $fillable = [
        'name', 
        'sex', 
        'birth_date', 
        'subspecies_id', 
        'enclosure_id', 
        'diet_plan_id'
    ];
    public function subspecies()
    {
        return $this->belongsTo(Subspecies::class);
    }

    public function enclosure()
    {
        return $this->belongsTo(Enclosure::class);
    }
    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Zwierzęta',
            'fields' => [
                'name' => ['label' => 'Imię', 'type' => 'text'],
                'sex' => ['label' => 'Płeć', 'type' => 'text'],
                'birth_date' => ['label' => 'Data urodzenia', 'type' => 'date'],
                'subspecies_id' => [
                    'label' => 'Podgatunek', 
                    'type' => 'relation', 
                    'model' => \App\Models\Subspecies::class, 
                    'display' => 'common_name'
                ],
                'enclosure_id' => [
                    'label' => 'Wybieg', 
                    'type' => 'relation', 
                    'model' => \App\Models\Enclosure::class, 
                    'display' => 'name'
                ],
                'diet_plan_id' => [
                    'label' => 'Dieta', 
                    'type' => 'relation', 
                    'model' => \App\Models\DietPlan::class, 
                    'display' => 'name'
                ],
            ]
        ];
    }
}