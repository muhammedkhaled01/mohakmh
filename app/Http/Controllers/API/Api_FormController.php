<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\FormEmail;
use App\Mail\ReceiveForm;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Api_FormController extends Controller
{

    public function __construct()
    {
        if (array_key_exists("HTTP_AUTHORIZATION", $_SERVER)) {
            $this->middleware("auth:sanctum");
        }
    }
    public function sendForm(Request $request)
    {
        // عمليات التحقق من الادخال المطلوب
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'subject' => 'required',
            'purpos' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'missing input',
            ];
            return response()->json($response, 400);
        }

        $user_id = auth()->user() ? auth()->user()->id : null;

        // dd($user_id);

        $form = Form::create([
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'subject' => $request->subject,
            'purpos' => $request->purpos,
            'user_id' => $user_id,
            'message' => $request->message,
        ]);

        Mail::to('mrtamous@hotmail.com')->send(new FormEmail(
            $request->email,
            $request->firstName,
            $request->lastName,
            $request->subject,
            $request->purpos,
            $request->message
        ));

        Mail::to($request->email)->send(new ReceiveForm(
            $request->email,
            $request->firstName,
            $request->lastName,
            $request->subject,
            $request->purpos,
            $request->message
        ));


        $response = [
            'status' => true,
            'message' => 'we will call you back soon',
        ];
        return response()->json($response, 200);
    }
}
