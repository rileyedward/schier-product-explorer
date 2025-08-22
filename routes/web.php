<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(ProductController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/favorites', 'favorites')->name('favorites');
            Route::post('/{product}/toggle-favorite', 'toggleFavorite')->name('toggle-favorite');
            Route::post('/sync', 'sync')->name('sync');
        });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
