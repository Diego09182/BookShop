<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MainController;

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
    return view('Shop.welcome');
})->name('welcome')->middleware('check.login');

// 登入
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 註冊
Route::post('/register', [AuthController::class, 'register'])->name('register');

// 身分驗證
Route::middleware(['auth'])->group(function () {

    //首頁
    Route::get('/main', [MainController::class, 'index'])->name('main');

    //登出
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 搜尋產品
    Route::get('/products/search', [ProductController::class, 'search'])->name('product.search');
    // 篩選產品
    Route::get('/products/filter', [ProductController::class, 'filter'])->name('product.filter');
    // 認同產品
    Route::post('/products/{product}/like', [ProductController::class, 'like'])->name('product.like');
    // 不認同產品
    Route::post('/{product}/dislike', [ProductController::class, 'dislike'])->name('product.dislike');
    // 顯示所有產品
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    // 發布產品頁面
    Route::get('/product', [ProductController::class, 'create'])->name('product.create');
    // 顯示單個產品
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    // 發布產品
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    // 刪除產品
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    // 顯示編輯產品頁面
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    // 更新產品
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    // 發布評論
    Route::post('/product/{product}/comment', [CommentController::class, 'store'])->name('comment.store');
    // 刪除評論
    Route::delete('/product/{product}/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // 購物車
    Route::post('/cart/product/{product}', [ProductController::class, 'addToCart'])->name('product.addToCart');
    // 顯示購物車
    Route::get('/cart', [ProductController::class, 'showCart'])->name('product.showCart');
    // 刪除購物車的商品
    Route::delete('/cart/product/{product}', [ProductController::class, 'removeFromCart'])->name('product.removeFromCart');
    // 購買購物車的商品
    Route::post('/cart/purchase', [ProductController::class, 'purchase'])->name('product.purchase');

    // 管理後臺
    Route::get('/management', [ManagementController::class, 'index'])->name('management.index');
    // 使用者管理
    Route::get('/management/users', [ManagementController::class, 'users'])->name('management.users');
    // 使用者更新
    Route::put('/management/management/{user}', [ManagementController::class, 'update'])->name('management.update');
    // 產品管理
    Route::get('/management/products', [ManagementController::class, 'products'])->name('management.products');
    // 訂單管理
    Route::get('/management/orders', [OrderController::class, 'index'])->name('management.orders');
    // 訂單更新
    Route::patch('/management/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    // 個人資訊
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // 個人商店
    Route::get('/profile/shop/{shop}', [ShopController::class, 'index'])->name('shop.index');
    // 個人資訊更新
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});
