<?php

use App\Data\CategoryData;
use App\Data\MenuItemData;
use App\Http\Controllers\ProfileController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', fn() => inertia('Home/HomePage'))->name('home');
Route::get('/menus', function () {
    $categories = Category::with('menuItems')->get();
    return inertia('Home/MenusPage', [
        'categories' => CategoryData::collect($categories)
    ]);
})->name('menus');

require __DIR__ . '/auth.php';
