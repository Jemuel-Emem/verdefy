<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phonenumber',
        'productlist',
        'totalorder',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(comments::class, 'order_id');
    }

}
