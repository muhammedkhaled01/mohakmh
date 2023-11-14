<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;

class Api_AuthController extends Controller
{
    /* public function login(Request $request)
    {
        // عمليات التحقق من الادخال المطلوب
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        // عمليات التحقق من الادخال الصحيح وتسجيل الدخول
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $response = [
                'status' => false,
                'message' => 'email or password wrong',
            ];
            return response()->json($response, 400);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken($user->name);
        $user['token'] = $token->plainTextToken;

        $response = [
            'status' => true,
            'message' => 'user login successfully',
            'data' => $user
        ];
        return response()->json([$response, 200]);
    } */

    public function login(Request $request)
    {
        // عمليات التحقق من الادخال المطلوب
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        $user = User::withTrashed()->where('email', $request->email)->first();
        if ($user->deleted_at != null) {
            $response = [
                'status' => false,
                'message' => 'This user has been blocked',
            ];
            return response()->json($response, 400);
        }
        // عمليات التحقق من الادخال الصحيح وتسجيل الدخول
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $response = [
                'status' => false,
                'message' => 'email or password wrong',
            ];
            return response()->json($response, 400);
        }


        // يتم توليد رقم عشوائي
        // ثم يتم ارسال ايميل لتاكيد الحساب
        $code = mt_rand(100000, 999999);
        Mail::to($request->email)->send(new VerificationEmail($request->name, $code));

        $user->email_verified_login_code = $code;
        $user->save();

        $response = [
            'status' => true,
            'message' => 'Check your email, we have sent you a verification code',
        ];
        return response()->json([$response, 200]);
    }

    public function logout(Request $request)
    {
        if (auth()->user()) {
            $user = auth()->user();
        }
        $request->user()->currentAccessToken()->delete();
        $response = [
            'status' => true,
            'message' => 'user logout successfully',
        ];
        //$user = auth()->user();
        return response()->json($response);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'job' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input'
            ];
            return response()->json($response, 400);
        }

        $existUser = User::withTrashed()->where('email', $request->email)->first();
        //return  $existUser;
        if ($existUser) {
            if ($existUser->deleted_at != null) {
                $response = [
                    'status' => true,
                    'message' => 'This user has been blocked'
                ];
                return response()->json($response);
            }
            if ($existUser->email_verified_at == null) {
                $response = [
                    'status' => true,
                    'message' => 'user exist but acount not verified'
                ];
                return response()->json($response);
            }
            $response = [
                'status' => true,
                'message' => 'this acount exist , you can login'
            ];
            return response()->json($response);
        }

        // يتم توليد رقم عشوائي
        // ثم يتم ارسال ايميل لتاكيد الحساب
        $code = mt_rand(100000, 999999);
        Mail::to($request->email)->send(new VerificationEmail($request->name, $code));

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'image' => 'uploads/user-image/1695996235-6483-food0.jpg',
            'job' => $input['job'],
            'password' => $input['password'],
            'email_verified_code' => $code,
            'email_verified_code_times' => 1,
        ]);

        // يتم انشاء التوكين ودمجها مع مصفوفة المستخدم
        $token = $user->createToken($user->name);
        $user['token'] = $token->plainTextToken;

        $response = [
            'status' => true,
            'message' => 'Check your email, we have sent you a verification code'
        ];
        return response()->json($response);
    }

    public function verificationloginemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verificationcode' => 'required',
            'email' => 'required',
        ], [
            'required' => ':attribute is required'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors()->all(),
            ];
            return response()->json($response, 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user->email_verified_login_code != $request->verificationcode) {
                return response()->json(['message' => 'wrong code or expired code'], 400);
            }
            $user->email_verified_login_code = null; // يمسح كود التحقق
            $user->save();

            // يتم انشاء التوكين ودمجها مع مصفوفة المستخدم
            $token = $user->createToken($user->name);
            $user['token'] = $token->plainTextToken;


            $response = [
                'status' => true,
                'message' => 'User login successfully',
                'data' => $user,
            ];
            // $user->tokens()->delete();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or wrong email'], 400);
        }
    }
    public function verificationemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verificationcode' => 'required',
        ], [
            'required' => 'this field  is required'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors()->all(),
            ];
            return response()->json($response, 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user->email_verified_code !== $request->verificationcode) {
                return response()->json(['message' => 'wrong code or expired code'], 400);
            }
            $datetime = Carbon::now();
            $user->email_verified_at = $datetime; // يضع تاريخ التاكيد
            $user->email_verified_code = null; // يمسح كود التحقق
            $user->email_verified_code_times = null; // يمسح عدد المحاولات
            $user->save();

            // يتم انشاء التوكين ودمجها مع مصفوفة المستخدم
            $token = $user->createToken($user->name);
            $user['token'] = $token->plainTextToken;


            $response = [
                'status' => true,
                'message' => 'User register successfully',
                'data' => $user,
            ];
            // $user->tokens()->delete();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or wrong email'], 400);
        }
    }

    public function resendemail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // حتى يتم تقييد عدد ارسال الاكواد
        if ($user->email_verified_at != null) {
            return response()->json(['message' => 'your email is verified'], 404);
        }

        if ($user->email_verified_code == null) {
            return response()->json(['message' => 'wrong move'], 404);
        }

        if ($user->email_verified_code_times > 5) {
            return response()->json(['message' => 'you send many request , please try later'], 404);
        }

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

            $code = 123456;  //mt_rand(100000, 999999);
            Mail::to($user->email)->send(new VerificationEmail($user->name, $code));

            $user->email_verified_code_times = $user->email_verified_code_times + 1;
            $user->email_verified_code = $code;
            $user->save();
            return response()->json(['message' => 'Check your email, we have sent you a verification code'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found or wrong email'], 400);
        }
    }
}
