<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function customer()
    {
        return $this->hasMany(Customer::class, 'unit_id');
    }
}
