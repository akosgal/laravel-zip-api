<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    public $timestamps = false;

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}