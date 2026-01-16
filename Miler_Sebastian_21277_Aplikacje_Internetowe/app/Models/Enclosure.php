<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enclosure extends Model
{
    
    protected $table = 'enclosures';

    protected $fillable = ['name', 'type', 'capacity', 'description'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
    public function isFull()
    {
        return $this->animals()->count() >= $this->capacity;
    }
}
