<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        "id_user",
        "paid_date",
        "status",
        "status_bill",
        "payment_type",
        "total_bill"
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id');
    }
    public function billDetaill()
    {
        return $this->belongsTo(Bill::class);
    }
}
