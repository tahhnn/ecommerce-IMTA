<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'id_cate',
        'price',
        'img',
        'description',
        'quantity',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cart(){
        return $this->hasMany(Cart::class,'id_product','id');
    }
    
    public function cartinproduct(){
        return $this->hasMany(CartInProduct::class,'product_id','id');
    }
}
