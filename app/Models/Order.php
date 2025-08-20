<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

      protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'gmail',
        'payment_method',
        'status',
        'total'
    ];

     public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

     public function orderProducts()
    {
         return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
