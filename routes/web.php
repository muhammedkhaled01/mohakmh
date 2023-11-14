<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CommunicationInformationController;
use Vonage\Client;
use App\Mail\MyTestEmail;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Facades\Mail;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentsController;
use \App\Http\Controllers\Admin\TransactionController;

use App\Mail\VerificationEmail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/tesst', function () {
    return "hello";
});
Route::get('/test', function () {
    $code = mt_rand(10000000, 99999999);
    return $code;
});

Route::get('/convertToImages', [BookController::class, 'convertToImages']);
Route::get('/json', [CommunicationInformationController::class, 'store']);
Route::get('/jsonshow', [CommunicationInformationController::class, 'index']);

// خدمة ارسال الرسائل عبر الجيميل
Route::get('/testEmail', function () {
    $name = "tareq";
    $code = "553455";
    Mail::to('tarekattar2000@yahoo.com')->send(new VerificationEmail($name, $code));
});
Route::get("form", [PaymentsController::class, "form"])->name("form");
Route::get("package/2/payment/callback", [PaymentsController::class, "callback"])->name("payment.callback");
Route::post('saveDataMoyasar', [PaymentsController::class, 'saveDataMoyasar']);
Route::get('getDataMoyasar', [PaymentsController::class, 'getDataMoyasar']);
Route::post('testPayment', [PaymentsController::class, 'testCreateTransaction']);

Route::get("local-transactions", [TransactionController::class, "localTransaction"])->name("local-transactions");
Route::get("create-local-transactions", [TransactionController::class, "createLocalTransaction"])->name("create-local-transactions");
Route::post("save-local-transactions", [TransactionController::class, "saveLocalTransaction"])->name("save-local-transactions");
Route::get("show-local-transactions/{id}", [TransactionController::class, "showLocalTransactions"])->name("show-local-transactions");
Route::post("update-local-transactions/{id}", [TransactionController::class, "updateLocalTransactions"])->name("update-local-transactions");
Route::delete("delete-local-transactions/{id}", [TransactionController::class, "destroyLocalTransactions"])->name("delete-local-transactions");


Route::get("international-transactions", [TransactionController::class, "internationalTransaction"])->name("international-transactions");
Route::delete("delete-international-transactions/{id}", [TransactionController::class, "destroyInternationalTransactions"])->name("delete-international-transactions");

Route::get('/testPhone', function () {
    $basic = new Basic("158b48da", "T5Uwx0KyqHMaeWw9");
    $client = new Client($basic);

    $response = $client->sms()->send(
        new SMS("970568292177", "Mohakama", "hello Tareq this is mohakama platform \n")
    );

    $message = $response->current();

    if ($message->getStatus() == 0) {
        return "The message was sent successfully\n";
    } else {
        return "The message failed with status: " . $message->getStatus() . "\n";
    }
});

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
