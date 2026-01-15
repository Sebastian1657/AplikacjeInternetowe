<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;
    
    protected $table = 'species';

    protected $fillable = ['name', 'description'];

    public function subspecies()
    {
        return $this->hasMany(Subspecies::class);
    }
    public function specializedUsers()
    {
        return $this->belongsToMany(User::class, 'specializations');
    }
}
