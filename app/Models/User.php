<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // سنحتاجها لاحقاً للموبايل

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',        // أضفنا هذا
        'password',
        'role',         // أضفنا هذا
        'avatar',       // أضفنا هذا
        'is_active',    // أضفنا هذا
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // العلاقات (Relationships)
    public function shop() {
        return $this->hasOne(Shop::class);
    }

    public function orders() {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function deliveryOrders() {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}