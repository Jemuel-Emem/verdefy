<?php

namespace App\Models;
use App\Models\Cart ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverysched extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','order_id', 'status', 'deliverydate', 'product_id',
    ];


public function carts()
    {
        return $this->belongsTo(Cart::class, 'id');
}

//     public function user()
// {
//     return $this->belongsToMany(User::class, 'user_id');
// }
public function user()
{
    return $this->belongsTo(User::class);
}
public function comments()
{
    return $this->hasMany(comments::class, 'order_id');
}

public function order()
{
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}
public function product()
{
    return $this->belongsTo(Products::class);
}

}
