<?php

namespace App\Models;

use App\Livewire\Admin\Dileverysched;
use App\Models\Carts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',

    ];

    public function product()
{
    return $this->belongsTo(Products::class, 'product_id');
}



    public function user()
{
    return $this->belongsToMany(User::class, 'user_id');
    return $this->belongsToMany(Dileverysched::class, 'user_id');
}




}
