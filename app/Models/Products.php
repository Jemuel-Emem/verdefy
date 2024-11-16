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
    public function comments()
    {
        return $this->hasMany(comments::class, 'order_id');
    }

    public function carts()
{
    return $this->hasMany(Cart::class, 'product_id');
}

public function orders()
{
    return $this->hasMany(Order::class);
}
}
