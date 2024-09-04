<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'type'
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function service_value(): HasMany
    {
        return $this->hasMany(ServiceValue::class);
    }
}
