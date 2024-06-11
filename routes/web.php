<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
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

Auth::routes();


Route::middleware(['auth'])->group(function () {
Route::get('/home', [HomeController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'index']);
Route::post('/send-employee-email', [HomeController::class, 'sendEmployeeEmail'])->name('send.employee.email');
Route::post('/downloadPdf', [HomeController::class, 'downloadPdf'])->name('downloadPdf');

});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('addpayment', [AdminController::class, 'addPayment'])->name('addpayment');
    Route::PUT('/users/{id}', [AdminController::class, 'update']);
    Route::DELETE('/users/{id}', [AdminController::class, 'destroy']);

});
