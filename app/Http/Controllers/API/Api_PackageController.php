<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\transactionsMoyasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Api_PackageController extends Controller
{
    public function packages(Request $request)
    {
        $packages = Package::with('advantages')->get();
        $response = [
            'status' => true,
            'message' => 'you have all packages',
            'data' => $packages,
        ];
        return response()->json($response);
    }
    public function package(Package $package)
    {
        $response = [
            'status' => true,
            'message' => 'you have one package',
            'data' => $package,
        ];
        return response()->json($response);
    }
    public function saveDataMoyasar(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'amount' => 'required|numeric', // Use 'numeric' instead of 'decimal'
            'status' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Get authenticated user's ID
        $user_id = auth()->user() ? auth()->user()->id : null;

        // Create a new transaction
        $transaction = transactionsMoyasar::create([
            'user_id' => $user_id,
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'status' => $request->input('status'),
        ]);

        // Check if the transaction was successfully created
        if ($transaction) {
            return response()->json([
                'status' => true,
                'message' => 'Payment Successful',
                'transaction' => $transaction, // Optionally, include the created transaction in the response
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create transaction',
            ], 500); // Use a more appropriate HTTP status code for server errors
        }
    }

}
