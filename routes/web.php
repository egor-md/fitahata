<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/catalog', [PublicController::class, 'catalog'])->name('catalog');
Route::get('/contacts', [PublicController::class, 'contacts'])->name('contacts');
Route::get('/article/{slug}', [PublicController::class, 'show'])->name('article.show');
Route::post('/api/orders', [PublicController::class, 'placeOrder'])->name('orders.place');
Route::post('/api/forms', [PublicController::class, 'submitForm'])->name('forms.submit');

// Публичный Google-вход отключен. Авторизация в админку — только по прямой ссылке /login.

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('upload-image', [UploadController::class, 'image'])->name('upload.image');
        Route::resource('orders', OrderController::class)->only(['index', 'show']);
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::resource('plants', PlantController::class)->except(['show']);
        Route::resource('recipes', RecipeController::class)->except(['show']);
    });
});

require __DIR__.'/settings.php';
