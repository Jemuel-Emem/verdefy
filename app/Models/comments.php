<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'rate',
        'user_id',
        'comment',
        'name'
    ];

    public function comments()
    {
        return $this->hasMany(comments::class, 'order_id');
    }
public function order()
{
    return $this->belongsTo(Order::class, 'order_id');  // Assuming order_id is the foreign key
}
    // public function order()
    // {
    //     return $this->belongsTo(Deliverysched::class, 'order_id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
