<?php

namespace App\Models\Vehicle;

use App\Models\Driver\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
