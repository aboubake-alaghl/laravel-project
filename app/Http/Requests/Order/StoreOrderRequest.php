<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Order table related
            // 'is_paid'         => 'required|boolean',
            // 'is_fragile'         => 'required|boolean',
            // 'status'          => 'required|in:LATER', // todo: Assuming "LATER" is the only allowed value for now 
            // 'order_qr_code'   => 'nullable|string|max:255',
            'description'     => 'required|string|max:1000', // todo: max length can be changed later todo
            // 'promo_code_id'   => 'nullable|integer|exists:promo_codes,id', todo: should be added later
            'customer_id'     => 'required|integer|exists:customers,id',
            'service_id'      => 'required|integer|exists:services,id',
            'from_address_id' => 'required|integer|exists:addresses,id',
            'to_address_id'   => 'nullable|integer|exists:addresses,id',


            // Order Proof Images related
            'photo' => 'nullable|mimes:jpg,jpeg,png,webp,gif|max:5120', // MAX 5MB
            // or if array
            // 'photo' => 'nullable|array', 
            // 'photo.*' => 'nullable|mimes:jpg,jpeg,png,webp,gif|max:5120', 

            'recipient' => 'required|array', 
            'recipient.name' => 'required|string', 
            'recipient.phone' => 'required|string', 
            'recipient.note' => 'nullable|string', 
        ];
    }
}
