<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'price_buy', 'price_sale', 'discount', 'supplier_id'];
    public $timestamps = false;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function ordersDetail()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }
}
