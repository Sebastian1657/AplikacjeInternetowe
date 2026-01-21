<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

class Subspecies extends Model implements Adminable
{
    protected $table = 'subspecies';

    protected $fillable = ['species_id', 'common_name', 'scientific_name'];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function cares()
    {
        return $this->hasMany(Care::class);
    }

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Podgatunki',
            'fields' => [
                'species_id' => [
                    'label' => 'Gatunek nadrzędny',
                    'type' => 'relation',
                    'model' => \App\Models\Species::class,
                    'display' => 'name'
                ],
                'common_name' => ['label' => 'Nazwa Polska', 'type' => 'text'],
                'scientific_name' => ['label' => 'Nazwa Łacińska', 'type' => 'text'],
            ]
        ];
    }
}
