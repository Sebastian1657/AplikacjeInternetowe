<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

class Enclosure extends Model implements Adminable
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

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Wybiegi',
            'fields' => [
                'name' => ['label' => 'Nazwa Wybiegu', 'type' => 'text'],
                'type' => ['label' => 'Typ (kod)', 'type' => 'text'], // Np. open_air
                'capacity' => ['label' => 'Pojemność', 'type' => 'number'],
            ]
        ];
    }
}
