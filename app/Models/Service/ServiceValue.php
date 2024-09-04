<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'service_attribute_id'
    ];

    // uncomment with needed
    // public function service_attribute(): BelongsTo
    // {
    //     return $this->belongsTo(ServiceAttribute::class);
    // }
}
