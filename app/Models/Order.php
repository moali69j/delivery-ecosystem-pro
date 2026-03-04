<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'shop_id', 'driver_id', 'subtotal', 'delivery_fee', 
        'total_price', 'status', 'customer_notes', 'change_needed', 
        'delivery_lat', 'delivery_long'
    ];

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}