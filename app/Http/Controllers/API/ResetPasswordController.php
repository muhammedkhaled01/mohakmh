<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    // هنا مسؤول عن ارسال الكود الى الايميل عند طلب المستخدم تغيير كلمة المرور
    public function resetpassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // حتى يتم تقييد عدد ارسال الاكواد
        if ($user->email_verified_code_times > 4) {
            return response()->json(['message' => 'you send many request , please try later'], 404);
        }
        // if ($user->email_verified_code != null) {
        //     return response()->json(['message' => 'we already send a code to your email'], 404);
        // }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        try {
            $user = User::where('email', $request->email)->first();

            $code = mt_rand(100000, 999999);
            Mail::to($user->email)->send(new VerificationEmail($user->name, $code));
            $user->email_verified_code_times = $user->email_verified_code_times + 1;
            $user->email_verified_code = $code;
            $user->save();
            return response()->json(['message' => 'Check your email, we have sent you a verification code'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or wrong email'], 400);
        }
    }


    // هنا تتم عملية التحقق من الكود المرسل عبر الايميل من خلال المستخدم
    public function verificationpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verificationcode' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user->email_verified_code != $request->verificationcode) {
                return response()->json(['message' => 'wrong code or expired code'], 400);
            }

            $user->email_verified_code = null;
            $user->save();

            $response = [
                'status' => true,
                'message' => 'you can change your password now',
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or wrong email'], 400);
        }
    }

    public function createnewpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                // 'message' => $validator->errors(),
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_code_times == null || $user->email_verified_code != null) {
            return response()->json(['message' => 'wrong move'], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user->update([
            'password' => $input['password'],
            'email_verified_code_times' => null,
        ]);

        // يتم انشاء التوكين ودمجها مع مصفوفة المستخدم
        $token = $user->createToken($user->name);
        $user['token'] = $token->plainTextToken;

        $response = [
            'status' => true,
            'message' => 'password changed successfully'
        ];
        return response()->json($response);
    }
}
