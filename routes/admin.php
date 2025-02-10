<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ChatbotController;
use App\Http\Controllers\Admin\TransactionSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Blog\BlogEditor;
use App\Livewire\Admin\Blog\BlogList;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Discount\DiscountEditor;
use App\Livewire\Admin\Discount\DiscountList;
use App\Livewire\Admin\Order\OrderDetail;
use App\Livewire\Admin\Order\OrderList;
use App\Livewire\Admin\Product\EditProductStock;
use App\Livewire\Admin\Product\ProductEditor;
use App\Livewire\Admin\Product\ProductList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('admin.route_prefix'),
    'as' => 'admin.',
], function () {
    // Route cho login và home
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/', function () {
        return Auth::check() ? redirect()->route('admin.dashboard') : redirect()->route('admin.login');
    })->name('home');

    // Đăng xuất
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Middleware admin
    Route::middleware(['admin'])->group(function () {
        // Dashboard
        Route::get('dashboard', AdminDashboard::class)->name('dashboard');

        // Quản lý sản phẩm
        Route::prefix('product')->as('product.')->group(function () {
            Route::get('/', ProductList::class)->name('index');
            Route::middleware('role:admin')->group(function () {
                Route::get('create', ProductEditor::class)->name('create');
                Route::get('edit/{id}', ProductEditor::class)->name('edit');
            });
            Route::get('stock/{id}', EditProductStock::class)->name('stock');
        });

        // Quản lý danh mục
        Route::get('category', CategoryManager::class)->name('category.index');

        // Đơn vị
        Route::get('shipping-method', App\Livewire\Admin\ShippingMethodManager::class)->name('shipping-method.index');


        // Đánh giá
        Route::get('review', App\Livewire\Admin\ProductReviewList::class)->name('review.index');

        // Quản lý mã giảm giá
        Route::prefix('discount')->as('discount.')->group(function () {
            Route::get('/', DiscountList::class)->name('index');
            Route::get('create', DiscountEditor::class)->name('create');
            Route::get('edit/{id}', DiscountEditor::class)->name('edit');
        });

        // Quản lý người dùng
        Route::prefix('slider')->as('slider.')->group(function () {
            Route::get('/', App\Livewire\Admin\Slider\SliderList::class)->name('index');
            Route::get('create', App\Livewire\Admin\Slider\SliderEditor::class)->name('create');
            Route::get('edit/{id}', App\Livewire\Admin\Slider\SliderEditor::class)->name('edit');
        });

        // Chatbot
        Route::get('chatbot/interface', [ChatbotController::class, 'interface'])->name('chatbot.interface.index');

        // Quản lý người dùng
        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', App\Livewire\Admin\User\UserList::class)->name('index');
            Route::get('create', App\Livewire\Admin\User\UserEditor::class)->name('create');
            Route::get('edit/{id}', App\Livewire\Admin\User\UserEditor::class)->name('edit');
        });

        // Quản lý bài viết
        Route::prefix('blog')->as('blog.')->group(function () {
            Route::get('/', BlogList::class)->name('index');
            Route::get('create', BlogEditor::class)->name('create');
            Route::get('edit/{id}', BlogEditor::class)->name('edit');
        });

        // Quản lý đơn hàng
        Route::prefix('order')->as('order.')->group(function () {
            Route::get('/', OrderList::class)->name('index');
            Route::get('/report',  App\Livewire\Admin\Order\OrderReport::class)->name('report');
            Route::get('detail/{id}', OrderDetail::class)->name('detail');
        });

        // Lịch sử hoạt động
        Route::prefix('log')->as('log.')->group(function () {
            Route::get('/', App\Livewire\Admin\Log\LogList::class)->name('index');
        });
    });
});
