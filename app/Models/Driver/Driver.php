<?php

namespace App\Models\Driver;

use App\Models\Address;
use App\Models\Service\Service;
use App\Models\Vehicle\Vehicle;
use App\Traits\MustVerifyPhone;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory,
        Notifiable,
        HasApiTokens,
        MustVerifyPhone;

    protected $guarded  = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the current location of the driver. 
     * May need changing to HasOne, depends on the usage later.
     */
    public function currentLocation(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'current_location_id');
    }

    /**
     * The delivery categories that the driver belongs to.
     */
    public function deliveryCategories(): BelongsToMany
    {
        return $this->belongsToMany(DeliveryCategory::class);
    }

    /**
     * The addresses that belong to the driver.
     */
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'driver_services');
    }

    // public function scopeByService(Builder $query)
    // {
    //     return $query->where('email', )
    // }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    // public function sendPasswordResetNotification($token): void
    // {

    //     $this->notify(new ResetPassword($url));
    // }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'drivers.' . $this->id;
    }
}
