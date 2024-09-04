<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Customer\Customer;
use App\Pipes\Customer\CreateCustomerAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{

    public function signup(StoreCustomerRequest $request)
    {
        try {
            Pipeline::send($request)
                ->through([
                    // VerifyOTP::class,
                    CreateCustomerAccount::class,
                    // WelcomeNotification::class
                ])
                ->thenReturn();
            return Response::created([
                'customer' => $request->customer,
                'token' => $request->token
            ]);
        } catch (Exception $e) {
            return Response::exception($e);
        }

        // OLD IMPLMENTION //
        // $validatedBody = $request->validated();
        // TODO: QR_CODE generation method or params needs further discussing. 

        // TODO: OTP Provider is missing
        // $phone_otp_record = PhoneOTP::limit(1)->where(["phone" => $validatedBody['phone']])->first();
        // $phone_otp = null;
        // if ($phone_otp_record && $phone_otp_record->phone_otp) {
        //     $phone_otp = $phone_otp_record->phone_otp;
        // } else {
        //     response(["OTP_MISMATCH"], 422); //TODO: Error structure needs negotiation, (suggested structure) array of errors 
        // }
        // if (!($phone_otp == $validatedBody['phone_otp'])) {
        //     response(["OTP_MISMATCH"], 422); //TODO: Error structure needs negotiation, (suggested structure) array of errors 
        // }

        // $created_customer = Customer::create([
        //     ...$validatedBody,
        //     'photo' => null,
        //     // 'qr_code' => rand(0, 1000) . rand(1000, 2000) . rand(2000, 3000), //todo: should have a real value
        //     'password' => Hash::make($validatedBody['password']),
        // ]);

        // if a photo exists in the body.
        // if (array_key_exists("photo", $validatedBody)) {
        //     // TODO: Asset Provider needs nogotition
        //     // $created_customer->photo = FUNCTION TO CONVERT PHOTO TO URL BASED ON PROVIDER;
        //     // $created_customer->save();
        // }
        // $token = $created_customer->createToken(time())->plainTextToken;
        // return response([
        //     'customer' => $created_customer,
        //     'token' => $token
        // ], 201);
    }

    // description: object is alawys sent with two attributes (email and password).
    // IF (email) is a numberic value then the controller will assume that it is the phone number and will find the customer by thier phone attribute
    // ELSE if the (email) is string then the controller will assume that is is the email and will find the  customer by thier email value if it does exists.
    public function signin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        $isEmail = Validator::make($data, [
            'email' => "required|email",
        ])->fails();

        $isNumeric = Validator::make($data, [
            'email' => "required|numeric",
        ])->fails();

        if (!$isEmail) {
            $customer = Customer::where('email', $data['email'])->first();
        } elseif (!$isNumeric) {
            $customer = Customer::where('phone', $data['email'])->first();
        } else {
            return Response::unauthorised(['invalid credentials']);
        }

        if (!$customer) {
            return Response::unauthorised(['invalid credentials']);
        }

        if (!$customer->is_active) {
            return Response::unauthorised(['customer blocked']);
        }

        if (Hash::check($data['password'], $customer->getAuthPassword())) {
            // Todo: if this line is kept, this means that the user CAN BE ONLY AUTHENTICATED IN ONE DEVICE ONLY.
            $customer->tokens()->delete(); // only be signed in, in this browser
            return Response::ok([
                'customer' => $customer,
                'token' => $customer->createToken(time())->plainTextToken
            ]);
        } else {
            return Response::unauthorised(['invalid credentials']);
        }
    }

    // todo: After the customer change thier password, they will have to sign in again
    public function reset_password(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $data = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|confirmed|min:8',
        ]);

        if (Hash::check($data['current_password'], $customer->getAuthPassword())) {
            $customer->tokens()->delete(); //Sign Customer out of all other devices.
            Response::ok(Customer::where('id', $customer->id)->update(["password" => Hash::make($data['new_password'])]));
        } else {
            return Response::unauthorised(['invalid credentials']);
        }
    }

    public function me()
    {
        return Response::ok(Auth::guard('customer')->user());
    }

    public function logout()
    {
        return Response::ok(Auth::guard('customer')->user()->currentAccessToken()->delete(), 'Logout successfully');
    }
}
