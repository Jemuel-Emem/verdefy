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

    ];
    public function comments()
    {
        return $this->hasMany(comments::class, 'order_id');
    }

}
