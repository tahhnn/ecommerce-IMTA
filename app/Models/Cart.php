<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_product',
        'id_user',
               
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cartinproduct(){
        return $this->hasMany(CartInProduct::class,'cart_id','id');
    }

}
