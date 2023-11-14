<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Api_FormController;
use App\Http\Controllers\API\Api_AuthController;
use App\Http\Controllers\API\Api_BookImageController;
use App\Http\Controllers\API\Api_CategoryController;
use App\Http\Controllers\API\Api_InformationController;
use App\Http\Controllers\API\Api_PackageController;
use App\Http\Controllers\API\Api_ProfileController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\Api_MoyasarTransaction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [Api_AuthController::class, 'login'])->middleware(['verifiedemail']);
Route::post('/verificationloginemail', [Api_AuthController::class, 'verificationloginemail'])->middleware(['verifiedemail']);
Route::post('/register', [Api_AuthController::class, 'register']); // من خلالها يرسل كود تحقق
Route::post('logout', [Api_AuthController::class, 'logout'])->middleware(['auth:sanctum', 'verified']);


Route::post('/verificationemail', [Api_AuthController::class, 'verificationemail']); // عملية التحقق
Route::post('/resendemail', [Api_AuthController::class, 'resendemail']); //اعادة ارسال كود التحقق


Route::post('/resetpassword', [ResetPasswordController::class, 'resetpassword'])->middleware(['verifiedemail']); // ارسال كود التحقق
Route::post('/resendcode', [ResetPasswordController::class, 'resendcode'])->middleware(['verifiedemail']); // ارسال كود التحقق
Route::post('/verificationpassword', [ResetPasswordController::class, 'verificationpassword'])->middleware(['verifiedemail']); // ادخال كود التحقق
Route::post('/createnewpassword', [ResetPasswordController::class, 'createnewpassword'])->middleware(['verifiedemail']); // اعادة تعيين كلمة المرور

Route::group([
    'middleware' => [],
], function () {
    // اختبار على الباقات
    // Packages
    Route::get('/packages', [Api_PackageController::class, 'packages']);
    Route::get('/package/{package}', [Api_PackageController::class, 'package']);
//    Route::post('/saveDataMoyasar}', [Api_PackageController::class, 'saveDataMoyasar']);
    Route::post('saveDataMoyasar', [\App\Http\Controllers\PaymentsController::class, 'saveDataMoyasar']);

    // الأقسام
    // Categories
    Route::get('/categories', [Api_CategoryController::class, 'categories']);
    Route::get('/category/{category}', [Api_CategoryController::class, 'category']);
    Route::get('/mainCategory/{id}', [Api_CategoryController::class, 'mainCategory']);
    // Route::get('/mainCategory/{category}', [Api_CategoryController::class, 'mainCategory']);

    // الكتب
    // Books
    Route::get('/books', [Api_BookImageController::class, 'books']);
    Route::get('/book/{bookid}', [Api_BookImageController::class, 'bookpages']);

    // فورم اتصل بنا
    // communication form
    Route::post('/sendForm', [Api_FormController::class, 'sendForm']);

    // معلومات المنصة
    // communication informations
    Route::get('/informations', [Api_InformationController::class, 'informations']);
});

// بيانات الحساب الشخصي
// profile
Route::get('/profile/{userid}', [Api_ProfileController::class, 'profile'])->middleware(['auth:sanctum']);
// تعديل الملف الشخصي
// edit profile
Route::post('/editprofile/{id}', [Api_ProfileController::class, 'editprofile'])->middleware(['auth:sanctum']);
// تغيير الصورة الشخصية
// change image profile
Route::post('/change-image-profile', [Api_ProfileController::class, 'changeImageProfile'])->middleware(['auth:sanctum']);
// الاستفسارات
// get forms
Route::get('/get-forms', [Api_ProfileController::class, 'getForms'])->middleware(['auth:sanctum']);
// اشترك الان
// subscribe now
Route::post('/subscribe-now', [Api_ProfileController::class, 'subscribeNow'])->middleware(['auth:sanctum']);
// ياقتي
// my package
Route::get('/my-package', [Api_ProfileController::class, 'myPackage'])->middleware(['auth:sanctum']);
// معاملات الدفع
// my -transactions
Route::get('/my-transactions', [Api_ProfileController::class, 'myTransaction'])->middleware(['auth:sanctum']);

Route::post('/moyasar-transaction', [Api_MoyasarTransaction::class, 'moysarTransaction'])->middleware(['auth:sanctum']);
