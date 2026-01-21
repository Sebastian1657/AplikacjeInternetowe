<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Interfaces\Adminable;

class User extends Authenticatable implements Adminable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function specializations()
    {
        return $this->belongsToMany(Species::class, 'specializations');
    }
    public function cares() {
        return $this->hasMany(Care::class);
    }
    public function hasRole(string $roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
    public function todaySchedule() {
        return $this->cares()->where('care_date', now()->toDateString());
    }
    public function isEmployee()
    {
        return $this->hasRole('employee'); 
    }
    public function isManager()
    {
        return $this->hasRole('manager'); 
    }
    public function isSupervisor()
    {
        return $this->hasRole('supervisor'); 
    }
    public function isAdministrator()
    {
        return $this->hasRole('admin'); 
    }

    public static function getAdminConfig(): array
    {
        return [
            'title' => 'Użytkownicy',
            'fields' => [
                'name' => ['label' => 'Imię', 'type' => 'text'],
                'last_name' => ['label' => 'Nazwisko', 'type' => 'text'],
                'email' => ['label' => 'Email', 'type' => 'email'],
                'role_id' => [
                    'label' => 'Rola', 
                    'type' => 'relation', 
                    'model' => \App\Models\Role::class, 
                    'display' => 'display_name'
                ],
            ]
        ];
    }
}
