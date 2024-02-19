<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartInProduct extends Model
{
    use HasFactory;
    protected $table = 'cart_in_product';
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'cart_id',
        'quantity',
             
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
