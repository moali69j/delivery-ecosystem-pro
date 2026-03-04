<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    protected $fillable = ['user_id', 'latitude', 'longitude'];

    public function driver() {
        return $this->belongsTo(User::class, 'user_id');
    }
}