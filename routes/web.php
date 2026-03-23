<?php

use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/contacts', [PublicController::class, 'contacts'])->name('contacts');
Route::get('/article/{slug}', [PublicController::class, 'show'])->name('article.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('upload-image', [UploadController::class, 'image'])->name('upload.image');
        Route::resource('plants', PlantController::class)->except(['show']);
        Route::resource('recipes', RecipeController::class)->except(['show']);
    });
});

require __DIR__.'/settings.php';
