<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ✅ ROOT "/" ROUTE WITH ROLE CHECK
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->is_admin ? 'products.create' : 'home');
    }

    return app(ProductController::class)->showByCategory('home');
})->name('root');

// CATEGORY PAGES
Route::get('/home', fn() => app(ProductController::class)->showByCategory('home'))->name('home');
Route::get('/snacks', fn() => app(ProductController::class)->showByCategory('snacks'))->name('snacks');
Route::get('/drinks', fn() => app(ProductController::class)->showByCategory('drinks'))->name('drinks');
Route::get('/canned', fn() => app(ProductController::class)->showByCategory('canned'))->name('canned');
Route::get('/noodles', fn() => app(ProductController::class)->showByCategory('noodles'))->name('noodles');
Route::get('/toiletries', fn() => app(ProductController::class)->showByCategory('toiletries'))->name('toiletries');
Route::get('/household', fn() => app(ProductController::class)->showByCategory('household'))->name('household');
Route::get('/school', fn() => app(ProductController::class)->showByCategory('school'))->name('school');
Route::get('/pasabuy', fn() => app(ProductController::class)->showByCategory('pasabuy'))->name('pasabuy');

// ABOUT PAGE
Route::view('/about', 'pages.about')->name('about');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CART
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// ADMIN PRODUCT MANAGEMENT
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');

});

require __DIR__.'/auth.php';
