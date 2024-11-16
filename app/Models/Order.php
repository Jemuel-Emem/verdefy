<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'totalorder',
        'quantity',
        'order_id',
    ];
    protected $table = 'orders';

    // public function user()
    // {
    //     return $this->belongsToMany(User::class, 'user_id');
    // }
    public function comments()
    {
        return $this->hasMany(comments::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }


// public function product()
// {
//     return $this->belongsTo(Products::class, 'product_id');
// }

}
