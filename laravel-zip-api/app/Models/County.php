<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}