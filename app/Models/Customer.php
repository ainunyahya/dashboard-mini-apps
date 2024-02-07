<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    protected $table = 'customers';
    protected $fillable = ['name', 'unit_id'];
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
