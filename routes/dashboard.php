<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\TwoFactorAuthenticatableController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/admin/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth:admin']
], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('index');
    //Categories Controller
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/admin/dashboard/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    // the method create is used to route me to the create page of the categories
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/show/{category}', [CategoriesController::class, 'show'])->name('categories.show');
    Route::get('/categories/edit/{category}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/delete/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{category}/products', [CategoriesController::class, 'showProducts'])->name('categories.products');
    //Stores Controller
    Route::resource('stores',StoreController::class);
    //Products Controller
    Route::resource('products', ProductsController::class);

    Route::get('/2fa',[TwoFactorAuthenticatableController::class,'index'])
    ->name('admin.2fa');
});
