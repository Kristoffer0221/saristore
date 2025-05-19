<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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

// SEARCH PAGE
Route::get('/search', [ProductController::class, 'search'])->name('search');


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
    // Admin Index
    Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    // Admin Create
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    // Admin Edit
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('products.update');
    // Admin Delete
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Admin User
    Route::get('/admin/users', [ProductController::class, 'user'])->name('admin.products.users');
    Route::post('/admin/users/{id}/update', [ProductController::class, 'updateUser'])->name('admin.products.update');
    Route::delete('/admin/users/{id}', [ProductController::class, 'deleteUser'])->name('admin.products.delete');
    Route::post('/admin/users/add', [ProductController::class, 'addUser'])->name('admin.user.add');
    Route::get('/admin/users/add', function () {
        return view('admin.products.add-user');
    })->name('admin.products.add.form');
    Route::post('/admin/admins/add', [ProductController::class, 'addAdmin'])->name('admin.admins.add');

    // Admin Order
     Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status.update');
    
});

Route::get('/paypal/pay', [PayPalController::class, 'payWithPayPal'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

// SHOW THE CHECKOUT PAGE
Route::get('/checkout', [CheckoutController::class, 'index'])->name('cart.checkout');

// PLACE ORDER SUBMISSION
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
// PLACE ORDER THANK YOU PAGE
Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');

Route::get('/paypal/return', [CheckoutController::class, 'handlePayPalReturn'])->name('paypal.return');
Route::get('/paypal/cancel', [CheckoutController::class, 'handlePayPalCancel'])->name('paypal.cancel');


require __DIR__.'/auth.php';
