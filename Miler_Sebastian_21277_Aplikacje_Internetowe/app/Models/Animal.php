<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
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

}