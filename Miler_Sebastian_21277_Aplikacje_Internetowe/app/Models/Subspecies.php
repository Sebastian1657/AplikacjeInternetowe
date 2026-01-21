<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subspecies extends Model
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
}
