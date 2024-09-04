<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeliveryCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The drivers that belong to the delivery category.
     */
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class);
    }
}
