<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Care extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function animal() {
        return $this->belongsTo(Animal::class);
    }
}
