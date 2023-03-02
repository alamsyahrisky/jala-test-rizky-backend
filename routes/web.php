<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// user
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [DetailController::class, 'index'])->name('detail');
Route::get('/profile',[ProfileController::class,'index'])->name('profile')->middleware(['auth']);
Route::put('/profile/{id}',[ProfileController::class,'update'])->name('update-profile')->middleware(['auth']);
Route::get('/checkout/validation/{id}',[CheckoutController::class,'validationStock'])->name('checkout_validation');
Route::post('/checkout/{id}', [CheckoutController::class, 'process'])->name('checkout_proses')->middleware(['auth']);
Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout')->middleware(['auth']);
Route::get('/checkout/remove/{id}', [CheckoutController::class, 'remove'])->name('checkout-remove')->middleware(['auth']);
Route::post('/checkout/confrim/{id}', [CheckoutController::class, 'success'])->name('checkout-success')->middleware(['auth']);
Route::get('/checkout/invoice/{code}', [CheckoutController::class, 'invoice'])->name('checkout-invoice')->middleware(['auth']);

// admin
Route::prefix('admin')->namespace('Admin')->middleware('auth','admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chart_category', [DashboardController::class, 'getCategory'])->name('chart-category');
    Route::get('/chart_order', [DashboardController::class, 'getOrder'])->name('chart-order');
    Route::resource('/user', '\App\Http\Controllers\Admin\UsersController');
    Route::resource('/category', '\App\Http\Controllers\Admin\CategoryController');
    Route::get('/product/get_data/{id}',[ProductController::class,'getData']);
    Route::resource('/product', '\App\Http\Controllers\Admin\ProductController');
    Route::resource('/invoice', '\App\Http\Controllers\Admin\InvoiceController');
    Route::resource('/stock', '\App\Http\Controllers\Admin\StockController');
    Route::resource('/order', '\App\Http\Controllers\Admin\OrderController');
});
