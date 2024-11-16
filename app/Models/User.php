<?php

namespace App\Models;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phonenumber',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected $table = 'users';
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function myorder()
    {
        return $this->hasMany(Deliverysched::class);
    }

    public function deliverySchedules()
    {
        return $this->hasMany(Deliverysched::class);
    }

}
