<?php

namespace App\Models\Customer;

use App\Models\Address;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $guard = 'customer';

    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'email',
        'phone',
        'phone_code',
        'photo',
        'default_address_id',
        'gender',
        'reset_otp',
        'email_confirm_otp',
        'dob',
        // 'qr_code',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
            'password' => 'hashed',
            'gender' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The addresses that belong to the customer.
     */
    public function addresses()
    {
        return $this->belongsToMany(Address::class);
    }
}
