<?php

namespace App\Http\Requests\Driver;

use Illuminate\Validation\Rule;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\DeliveryStatus;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['email', 'unique:drivers,email'],
            'phone' => ['required', 'unique:drivers,phone', 'string'],
            'password' => [
                'required',
                Password::min(8),
                Password::min(8)->letters(),
                Password::min(8)->mixedCase(),
                Password::min(8)->numbers(),
            ],
            'dob' => ['date', 'nullable'],
            'gender' => ['required', 'boolean'],
            'passport_no' => ['string', 'nullable'],
            'criminal_case' => ['string', 'nullable'],
            'national_no' => ['integer', 'nullable'],
            'delivery_status' => ['required', Rule::enum(DeliveryStatus::class)],
            'status' => ['required', Rule::enum(DriverStatus::class)],
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException(
            $validator,
            Response::unprocessable($validator->errors())
        );
    }
}
