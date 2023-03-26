<?php

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

Auth::routes();

Route::group(['middleware' => ['auth', 'is_admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    // admin
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('attributes', \App\Http\Controllers\Admin\AttributeController::class);
    Route::resource('attributes.attribute_options', \App\Http\Controllers\Admin\AttributeOptionController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('products.product_images', \App\Http\Controllers\Admin\ProductImageController::class);
    
    Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class);
    Route::get('slides/{slideId}/up', [\App\Http\Controllers\Admin\SlideController::class, 'moveUp']);
    Route::get('slides/{slideId}/down', [\App\Http\Controllers\Admin\SlideController::class, 'moveDown']);

    Route::get('orders/trashed', [\App\Http\Controllers\Admin\OrderController::class , 'trashed'])->name('orders.trashed');
    Route::get('orders/restore/{order:id}', [\App\Http\Controllers\Admin\OrderController::class , 'restore'])->name('orders.restore');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::post('orders/complete/{order}', [\App\Http\Controllers\Admin\OrderController::class , 'doComplete'])->name('orders.complete');
    Route::get('orders/{order:id}/cancel', [\App\Http\Controllers\Admin\OrderController::class , 'cancel'])->name('orders.cancels');
	Route::put('orders/cancel/{order:id}', [\App\Http\Controllers\Admin\OrderController::class , 'doCancel'])->name('orders.cancel');
    Route::resource('shipments', \App\Http\Controllers\Admin\ShipmentController::class);

    Route::get('reports/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/product', [\App\Http\Controllers\Admin\ReportController::class, 'product'])->name('reports.product');
    Route::get('reports/inventory', [\App\Http\Controllers\Admin\ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('reports/payment', [\App\Http\Controllers\Admin\ReportController::class, 'payment'])->name('reports.payment');
});


Route::get('/', [\App\Http\Controllers\Frontend\HomepageController::class, 'index']);
Route::get('products', [\App\Http\Controllers\Frontend\ProductController::class, 'index']);
Route::get('product/{product:slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('product.detail');
Route::get('products/quick-view/{product:slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'quickView']);

Route::get('carts', [\App\Http\Controllers\Frontend\CartController::class, 'index'])->name('carts.index');
Route::post('carts', [\App\Http\Controllers\Frontend\CartController::class, 'store'])->name('carts.store');
Route::post('carts/update', [\App\Http\Controllers\Frontend\CartController::class, 'update']);
Route::get('carts/remove/{cartId}', [\App\Http\Controllers\Frontend\CartController::class, 'destroy']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('orders/checkout', [\App\Http\Controllers\Frontend\OrderController::class, 'checkout'])->middleware('auth');
    Route::post('orders/checkout', [\App\Http\Controllers\Frontend\OrderController::class, 'doCheckout'])->name('orders.checkout')->middleware('auth');
    Route::get('orders/cities', [\App\Http\Controllers\Frontend\OrderController::class, 'cities'])->middleware('auth');
    Route::post('orders/shipping-cost', [\App\Http\Controllers\Frontend\OrderController::class, 'shippingCost'])->middleware('auth');
    Route::post('orders/set-shipping', [\App\Http\Controllers\Frontend\OrderController::class, 'setShipping'])->middleware('auth');
    Route::get('orders/received/{orderId}', [\App\Http\Controllers\Frontend\OrderController::class, 'received']);
    Route::get('orders', [\App\Http\Controllers\Frontend\OrderController::class, 'index']);
    Route::get('orders/{orderId}', [\App\Http\Controllers\Frontend\OrderController::class, 'show']);
    
    Route::resource('wishlists', \App\Http\Controllers\Frontend\WishListController::class)->only(['index','store','destroy']);
    
    Route::get('profile',  [\App\Http\Controllers\Auth\ProfileController::class, 'index']);
    Route::put('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'update']);

});

Route::post('payments/notification', [\App\Http\Controllers\Frontend\PaymentController::class, 'notification']);
Route::get('payments/completed', [\App\Http\Controllers\Frontend\PaymentController::class, 'completed']);
Route::get('payments/failed', [\App\Http\Controllers\Frontend\PaymentController::class, 'failed']);
Route::get('payments/unfinish', [\App\Http\Controllers\Frontend\PaymentController::class, 'unfinish']);