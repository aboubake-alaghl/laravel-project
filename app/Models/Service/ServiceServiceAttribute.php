<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceServiceAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_attribute_id',
        'service_id'
    ];
}
