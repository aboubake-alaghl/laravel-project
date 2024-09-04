<?php

namespace App\Models\Order;

use App\Models\Address;
use App\Models\Customer\Customer;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_paid',
        // 'is_fragile',
        'status',
        // 'order_qr_code',
        'description',
        'promo_code_id',
        'customer_id',
        'service_id',
        'from_address_id',
        'to_address_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function fromAddress()
    {
        return $this->belongsTo(Address::class, 'from_address_id');
    }

    public function toAddress()
    {
        return $this->belongsTo(Address::class, 'to_address_id');
    }

    public function proofImages()
    {
        return $this->hasMany(OrderProofImage::class);
    }

    public function priceFactors()
    {
        return $this->hasMany(OrderPriceFactor::class);
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);
    }
}
