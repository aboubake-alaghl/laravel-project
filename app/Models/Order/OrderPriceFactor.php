<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPriceFactor extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
        'value',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
