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
        "total_bill",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
