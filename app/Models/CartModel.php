<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_product',
        'id_user',
        'address',
        'quantity',
        'amount',        
    ];
    public function product(){
        return $this->belongsTo(ProductModel::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
