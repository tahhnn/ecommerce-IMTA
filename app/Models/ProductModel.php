<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_cate',
        'price',
        'img',
        'description',
        'quantity',
    ];
    public function category(){
        return $this->belongsTo(CateModel::class);
    }
    public function cart(){
        return $this->hasMany(CartModel::class,'id_product','id');
    }
}
