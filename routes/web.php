<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuItemReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSetupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/setup', [ProfileSetupController::class, 'create'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])->name('profile.setup.store');
});

Route::get('/', fn () => inertia('Home/HomePage'))->name('home');
Route::get('/menus', [MenuItemController::class, 'index'])->name('menus.index');
Route::get('/menus/{slug}', [MenuItemController::class, 'show'])->name('menus.show');
Route::apiResource('menus.reviews', MenuItemReviewController::class)->only(['index', 'store']);

Route::get('/menus/checkout/{key}', [CheckoutController::class, "show"])->name('menus.checkout.show');
Route::post('/menus/checkout', [CheckoutController::class, "store"])->name('menus.checkout.store');
require __DIR__.'/auth.php';
