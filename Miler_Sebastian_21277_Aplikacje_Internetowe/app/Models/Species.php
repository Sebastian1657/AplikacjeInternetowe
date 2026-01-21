<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

class Species extends Model implements Adminable
{
    
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
    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Gatunki',
            'fields' => [
                'name' => ['label' => 'Nazwa Gatunku', 'type' => 'text'],
            ]
        ];
    }
}
