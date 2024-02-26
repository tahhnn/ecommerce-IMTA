<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerBillController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'home'])->name('welcome');

Route::get('/home', [ProductController::class, 'home']);


// Route::match('/detail/{id}/{user_id}',[ProductController::class,'detail']);


Route::match(['POST', 'GET'], '/detail/{id}', [ProductController::class, 'detail'])->name('product.addCart');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::match(['POST', 'GET'], '/cartClient', [CartController::class, 'getCart'])->name('cart');

    Route::match(['POST', 'GET'], '/cartClient', [CartController::class, 'getCartClient'])->name('cart');
    Route::match(['POST', 'GET'], '/cartClient', [CartController::class, 'getCart'])->name('cart');
});

Route::get('/cart-delete/{id}', [CartController::class, 'deleteCart'])->middleware('auth');

Route::middleware('auth')->group(function () {


    Route::match(['POST', 'GET'], '/product', [ProductController::class, 'list'])->name('product.list');
    Route::match(['POST', 'GET'], '/detail/{id}/{user_id}', [ProductController::class, 'detail'])->name('product.addCart');
    Route::match(['POST', 'GET'], '/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::match(['POST', 'GET'], '/product-edit/{id}', [ProductController::class, 'update'])->name('product.edit');
    Route::get('/product-delete/{id}', [ProductController::class, 'delete']);

    Route::match(['POST', 'GET'], '/category', [CategoryController::class, 'list'])->name('category.list');
    Route::match(['POST', 'GET'], '/category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::match(['POST', 'GET'], '/category-edit/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category-delete/{id}', [CategoryController::class, 'delete']);



    Route::match(['POST', 'GET'], '/cartDetail', [CartController::class, 'getCart'])->name('cart.cartDetail');
    Route::match(['POST', 'GET'], '/cart', [CartController::class, 'getAllCart'])->name('cart.list');
    Route::match(['POST', 'GET'], '/cartDetail', [CartController::class, 'getCartAdmin'])->name('cart.cartDetail');
    Route::match(['POST', 'GET'], '/cart', [CartController::class, 'getAllCart'])->name('cart.list');
    Route::match(['POST', 'GET'], '/cartDetail', [CartController::class, 'getCartAdmin'])->name('cart.cartDetail');
});



Route::middleware('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::resource('/bill', BillController::class)->names('bills');
    Route::get('/bill/status-bill/{status_bill}', [BillController::class, "find_bill_by_statusBill"])->name('bills.find_bill_by_statusBill');
    Route::get('/bill/acept-bill/{status_bill}', [BillController::class, "Acept_bill"])->name('bills.Acept_bill');
    Route::get('/billDetail/{billDetail}', [BillDetailController::class, 'deleteBillDetail'])->name('bills.billDetailroute');
});

Route::middleware('customer')->group(function () {
    Route::resource('/bill-client', CustomerBillController::class)->names('billClient');
    Route::get('/billDetail/{billDetail}', [BillDetailController::class, 'deleteBillDetail'])->name('billClient.billDetailroute');
    Route::get('/return-payment/{id}', [CustomerBillController::class, 'return_payment'])->name('billClient.return_payment');
    Route::post('/bill-payment', [CustomerBillController::class, 'vnpay_payment'])->name('billClient.vnpay_payment');
    Route::get('/bill-client/status_bill/{status_bill}', [CustomerBillController::class, 'find_bill_by_statusBill'])->name('billClient.find_bill_by_statusBill');
    Route::delete('/bill-client/cancel/{id}', [CustomerBillController::class, 'cancel_bill'])->name('billClient.cancel_bill');
});

require __DIR__ . '/auth.php';
