<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ShopController;

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

// Laravel版本
Route::get('/', function () {
    return view('welcome');
});

// 登入首頁
Route::get('/welcome', function () {
    return view('BookStore.welcome');
})->name('welcome');

// 登入
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 註冊
Route::post('/register', [AuthController::class, 'register'])->name('register');

// 身分驗證
Route::middleware(['auth'])->group(function () {

    //首頁
    Route::get('/main', function () {
        return view('BookStore.index');
    })->name('main');

    //登出
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 搜尋產品
    Route::get('/bookstore/products/search', [ProductController::class, 'search'])->name('product.search');
    // 篩選產品
    Route::get('/bookstore/products/filter', [ProductController::class, 'filter'])->name('product.filter');
    // 認同產品
    Route::post('/bookstore/products/{product}/like', [ProductController::class, 'like'])->name('product.like');
    // 不認同產品
    Route::post('/bookstore/products/{product}/dislike', [ProductController::class, 'dislike'])->name('product.dislike');
    // 顯示所有產品
    Route::get('/bookstore/products', [ProductController::class, 'index'])->name('product.index');
    // 發布產品頁面
    Route::get('/bookstore/product', [ProductController::class, 'create'])->name('product.create');
    // 顯示單個產品
    Route::get('/bookstore/product/{product}', [ProductController::class, 'show'])->name('product.show');
    // 發布產品
    Route::post('/bookstore/product', [ProductController::class, 'store'])->name('product.store');
    // 刪除產品
    Route::delete('/bookstore/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    // 發布評論
    Route::post('/bookstore/product/{product}/comment', [CommentController::class, 'store'])->name('comment.store');
    // 刪除評論
    Route::delete('/bookstore/product/{product}/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // 購物車
    Route::post('//product/{product}/cart', [ProductController::class, 'addToCart'])->name('product.addToCart');
    Route::get('/bookstore/cart', [ProductController::class, 'showCart'])->name('product.showCart');
    Route::delete('/bookstore/cart/{product}', [ProductController::class, 'removeFromCart'])->name('product.removeFromCart');
    Route::post('/bookstore/cart/purchase', [ProductController::class, 'purchase'])->name('product.purchase');

    // 管理後臺
    Route::get('/management', [ManagementController::class, 'index'])->name('management.index');
    // 後台管理
    Route::put('/swiftfox/management/management/{user}', [ManagementController::class, 'update'])->name('management.update');

    // 個人資訊
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // 個人商店
    Route::get('/profile/shop/{shop}', [ShopController::class, 'index'])->name('shop.index');
    // 個人資訊更新
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});
