<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProofImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'order_id',
        'uploader_id',
        'uploader_type',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
