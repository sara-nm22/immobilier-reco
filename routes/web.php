<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
