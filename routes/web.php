<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/contacts', [PublicController::class, 'contacts'])->name('contacts');
Route::get('/test_card', [PublicController::class, 'testCard'])->name('test.card');

Route::get('/article/{slug}', [PublicController::class, 'article'])->name('article.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::post('upload-image', [UploadController::class, 'image'])->name('upload.image');
        Route::patch('articles/{article}/visibility', [ArticleController::class, 'toggleVisibility'])->name('articles.toggle-visibility');
        Route::resource('articles', ArticleController::class);
        Route::resource('blocks', BlockController::class);
    });
});

require __DIR__.'/settings.php';
