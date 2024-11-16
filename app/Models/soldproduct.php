<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soldproduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'total_sold',


    ];


public function product()
{
    return $this->belongsTo(Products::class, 'product_id'); // assuming 'product_id' is the foreign key
}

}
