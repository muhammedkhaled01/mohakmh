<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth', 'user.role:admin,super-admin', 'verified'],
    'as' => 'dashboard.',
    'prefix' => 'dashboard'
], function () {


    // Main page
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/forceDelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
    Route::resource('/categories', CategoryController::class);

    // Convert books
    Route::get('/books/convertpdf', [BookController::class, 'convertpdf']);
    Route::get('/books/converttoimage', [BookController::class, 'converttoimage']);
    Route::get('/books/{book}/view', [BookController::class, 'view'])->name('books.view');
    // Books
    Route::get('/books/trash', [BookController::class, 'trash'])->name('books.trash');
    Route::put('/books/{book}/restore', [BookController::class, 'restore'])->name('books.restore');
    Route::delete('/books/{book}/forceDelete', [BookController::class, 'forceDelete'])->name('books.forceDelete');
    Route::resource('/books', BookController::class);


    // Packages
    Route::get('/packages/trash', [PackageController::class, 'trash'])->name('packages.trash');
    Route::put('/packages/{book}/restore', [PackageController::class, 'restore'])->name('packages.restore');
    Route::delete('/packages/{book}/forceDelete', [PackageController::class, 'forceDelete'])->name('packages.forceDelete');
    Route::resource('/packages', PackageController::class);

    // Users
    Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::put('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{user}/forceDelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    // Route::post('/users/{user}', [UserController::class, 'destroy'])->middleware('checkdelete');
    Route::resource('/users', UserController::class);
    // transactions
    Route::get('/transactions/trash', [TransactionController::class, 'trash'])->name('transactions.trash');
    Route::put('/transactions/{user}/restore', [TransactionController::class, 'restore'])->name('transactions.restore');
    Route::delete('/transactions/{user}/forceDelete', [TransactionController::class, 'forceDelete'])->name('transactions.forceDelete');
    // Route::post('/transactions/{user}', [TransactionController::class, 'destroy'])->middleware('checkdelete');
    Route::resource('/transactions', TransactionController::class);

    // Reports
    Route::get('/reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
    Route::get('/reports/{report}/view', [ReportController::class, 'view'])->name('reports.view');
    // Route::get('/reports/generate', [ReportController::class, 'generateUserReport'])->name('reports.generate');
    // Route::get('/reports/generate', [ReportController::class, 'generatePackageReport'])->name('reports.generate');
    // Route::get('/reports/generate', [ReportController::class, 'generateSubscriptionReport'])->name('reports.generate');
    Route::get('/reports/generate', [ReportController::class, 'generateGeneralReport'])->name('reports.generate');
    Route::get('/reports/trash', [ReportController::class, 'trash'])->name('reports.trash');
    Route::put('/reports/{report}/restore', [ReportController::class, 'restore'])->name('reports.restore');
    Route::delete('/reports/{report}/forceDelete', [ReportController::class, 'forceDelete'])->name('reports.forceDelete');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('/reports/{report}/destroy', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Communication Informations
    Route::resource('/informations', InformationController::class);

    // Communication Forms
    // Route::resource('/communicationForm', ::class);

    // Communication Forms
    Route::get('/forms/trash', [FormController::class, 'trash'])->name('forms.trash');
    Route::put('/forms/{form}/restore', [FormController::class, 'restore'])->name('forms.restore');
    Route::delete('/forms/{form}/forceDelete', [FormController::class, 'forceDelete'])->name('forms.forceDelete');
    Route::resource('/forms', FormController::class);
});
