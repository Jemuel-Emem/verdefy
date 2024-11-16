<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'productname',
        'productprice',
        'description',
        'stocks',
        'photo',
        'total_sold'

    ];

    // In Product.php (Product model)
public function comments()
{
    return $this->hasManyThrough(comments::class, Order::class, 'product_id', 'order_id');
}

    public function soldProducts()
{
    return $this->hasMany(SoldProduct::class, 'product_id');
}

    // public function comments()
    // {
    //     return $this->hasMany(comments::class, 'order_id');
    // }

    public function carts()
{
    return $this->hasMany(Cart::class, 'product_id');
}

public function orders()
{
    return $this->hasMany(Order::class);
}
}
