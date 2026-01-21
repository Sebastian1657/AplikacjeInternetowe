<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Adminable;

class Role extends Model
{

    protected $table = 'roles';

    protected $fillable = ['name', 'display_name', 'permissions', 'description'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Role Systemowe',
            'fields' => [
                'name' => ['label' => 'Kod roli', 'type' => 'text'],
                'display_name' => ['label' => 'Nazwa wyświetlana', 'type' => 'text'],
                'description' => ['label' => 'Opis', 'type' => 'text'],
            ]
        ];
    }
}
