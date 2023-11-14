<?php

namespace App\Http\Controllers;

use App\Models\InternationalTransactions;
use App\Models\Package;
use App\Models\transactionsMoyasar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

class PaymentsController extends Controller
{
    public function form(Package $package)
    {
        return view("payments.form", [
            'package' => $package,
        ]);
    }

    public function callback(Request $request, Package $package)
    {
        $userName = Auth::user()->name;
        $id = \request()->query('id');
        $token = base64_encode(config('services.moyasar.secret') . ':');
        $payment = Http::baseUrl("https://api.moyasar.com/v1")->withHeaders([
            'Authorization' => "Basic {$token}",
        ])
            ->get("payments/{$id}")
            ->json();
        if ($payment['status'] == 'paid') {
            $transactions = InternationalTransactions::all();

            $transactions = new InternationalTransactions();
            $transactions->payment_id = $payment['id'];
            $transactions->name = $userName;
            $transactions->package_id = $payment['description'];
            $transactions->tax = 50;
            $transactions->price = $payment['amount'] + $transactions->tax;
            $transactions->status = 'paid';
            $transactions->save();

            return redirect()->back()->with("success", "تم الدفع بنجاح");


        } else {
            return redirect()->back()->with("success", "لم يتم الدفع بنجاح");
        }

    }

    public function saveDataMoyasar(Request $request)
    {
        // Validation rules
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
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

    public function getDataMoyasar()
    {
        $data = InternationalTransactions::all();
        return response()->json(['data' => $data]);
    }


    public function testCreateTransaction()
    {
        // You may need to adjust the route and payload based on your actual implementation
        $response = $this->json('POST', 'testPayment', [
            'description' => 'Test Transaction',
            'amount' => 100.00,
            'status' => 'success',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Payment Successful',
            ]);

        // Optionally, you can assert the database to ensure the transaction is created
        $this->assertDatabaseHas('transactions', [
            'description' => 'Test Transaction',
            'amount' => 100.00,
            'status' => 'success',
        ]);
    }
}
