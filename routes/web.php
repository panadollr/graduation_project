<?php

use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\ProductListController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/san-pham/{product_slug}',[ProductDetailController::class, 'index'])->name('product');
Route::get('/danh-sach/{category_slug}',[ProductListController::class, 'index'])->name('list');
Route::get('/tim-kiem', [ProductListController::class, 'search'])->name('search');
Route::prefix('bai-viet')->as('blog.')->group(function () {
    Route::get('/', App\Livewire\Client\Blog\BlogList::class)->name('index');
    Route::get('/{slug}', App\Livewire\Client\Blog\BlogDetail::class)->name('detail');
    // Route::get('edit/{id}', BlogEditor::class)->name('edit');
});

Route::middleware('user')->group(function () {
    Route::controller(AccountController::class)->prefix('account')->as('account.')->group(function () {
        Route::get('/bang-dieu-khien', 'index')->name('index');
        Route::get('/ho-so', App\Livewire\Client\Account\MyProfile::class)->name('profile.index');
        Route::get('/dia-chi-cua-toi', App\Livewire\Client\Account\MyAddresses::class)->name('address.index');
        Route::get('/don-hang-cua-toi', App\Livewire\Client\Account\MyOrders::class)->name('purchase.index');
        Route::get('/dang-xuat', 'logout')->name('logout');
    });

    Route::get('/thanh-toan',[CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/vnpay/return',[CheckoutController::class, 'vnpayReturn'])->name('checkout.vnpay-return');
    Route::get('/thanh-toan/thanh-cong',[CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/gio-hang',[CartController::class, 'index'])->name('cart.index');

});

// Include routes cho admin
require base_path('routes/admin.php');
