<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Care extends Model
{
    use HasFactory;
    protected $table = 'cares';
    protected $fillable = ['care_date', 'shift', 'user_id', 'subspecies_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function subspecies() {
        return $this->belongsTo(Subspecies::class);
    }
}
