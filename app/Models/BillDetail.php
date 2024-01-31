<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bill',
        "id_product",
        "quantity",
    ];
    public function bill()
    {
        return $this->hasOne(Bill::class, 'id_bill', 'id');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id_product', 'id');
    }
}
