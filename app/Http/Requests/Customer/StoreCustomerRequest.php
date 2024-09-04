<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;

class StoreCustomerRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'nullable|string|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'phone_code' => 'required|string',
            'photo' => 'nullable|mimes:jpg,jpeg,png,webp,gif|max:5120', // MAX 5MB
            'gender' => 'required|boolean',
            'dob' => 'nullable|date',
            'phone_otp' => 'nullable|integer|min:10000|digits:5', //TODO: should be required
            // 'default_address_id'  => 'nullable|integer|exists:addresses,id',
            // 'reset_otp' => 'nullable|string|max:6',
            // 'email_confirm_otp' => 'nullable|string|max:6',
            // 'qr_code' => 'required|string|max:255|unique:customers,qr_code',
        ];
    }


    protected function failedValidation(Validator $validator)
    {

        // dd($validator);
        // return $validator;
        $errors = [];

        // Flattening the error messages
        foreach ($validator->errors()->all() as $error) {
            $errors[] = $error;
        }

        throw new \Illuminate\Validation\ValidationException(
            $validator,
            Response::unprocessable($errors, "Validation Error")
        );
    }
}
