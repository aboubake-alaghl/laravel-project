<?php

namespace App\Models;

use App\Models\Customer\Customer;
use App\Models\Driver\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lat',
        'lng',
        'zone_id',
    ];

    /**
     * Get the zone associated with the address (1 - M).
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    /**
     * The drivers that belong to the address.
     */
    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }
}
