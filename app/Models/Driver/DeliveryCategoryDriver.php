<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCategoryDriver extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'delivery_category_id',
    ];
}
