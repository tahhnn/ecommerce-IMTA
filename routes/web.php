<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('client.home');
})->name('welcome');

Route::get('/home',[ProductController::class,'home']);
Route::get('/detail/{id}',[ProductController::class,'detail']);
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::match(['POST','GET'],'/product', [ProductController::class, 'list'])->name('product.list');
    Route::match(['POST','GET'],'/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::match(['POST','GET'],'/product-edit/{id}', [ProductController::class, 'update'])->name('product.edit');
    Route::get('/product-delete/{id}', [ProductController::class, 'delete']);
    
    Route::match(['POST','GET'],'/category', [CategoryController::class, 'list'])->name('category.list');
    Route::match(['POST','GET'],'/category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::match(['POST','GET'],'/category-edit/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category-delete/{id}', [CategoryController::class, 'delete']);
});

require __DIR__.'/auth.php';
