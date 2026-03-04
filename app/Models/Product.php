<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['shop_id', 'name', 'description', 'price', 'image', 'is_available'];

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}