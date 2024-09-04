<?php

namespace App\Models\Service;

use App\Models\Driver\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
    public function service_attributes(): BelongsToMany
    {
        return $this->belongsToMany(ServiceAttribute::class);
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class);
    }
}
