<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::redirect('/', '/dashboard');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// MATERIAL ROUTES
Route::get('/materials', [App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
Route::post('/add-material', [App\Http\Controllers\MaterialController::class, 'postMaterial'])->name('materials.add');
Route::get('/show-material/{material}', [App\Http\Controllers\MaterialController::class, 'showMaterial'])->name('materials.show');
Route::put('/edit-material/{material}', [App\Http\Controllers\MaterialController::class, 'putMaterial'])->name('materials.edit');
Route::delete('/delete-material/{material}', [App\Http\Controllers\MaterialController::class, 'deleteMaterial'])->name('materials.delete');
Route::put('materials/{material}/status', [App\Http\Controllers\MaterialController::class, 'toggleStatus'])->name('materials.toggle_status');

// ITEM ROUTES
Route::get('/items', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
Route::post('/add-item', [App\Http\Controllers\ItemController::class, 'postItem'])->name('items.add');
Route::get('/show-item/{item}', [App\Http\Controllers\ItemController::class, 'showItem'])->name('items.show');
Route::put('/edit-item/{item}', [App\Http\Controllers\ItemController::class, 'putItem'])->name('items.edit');
Route::delete('/delete-item/{item}', [App\Http\Controllers\ItemController::class, 'deleteItem'])->name('items.delete');
Route::put('items/{item}/status', [App\Http\Controllers\ItemController::class, 'toggleStatus'])->name('items.toggle-status');
Route::post('/add-ingredients/{item}', [App\Http\Controllers\ItemController::class, 'postIngredients'])->name('items.add-ingredients');
Route::put('/edit-ingredients/{item}', [App\Http\Controllers\ItemController::class, 'putIngredients'])->name('items.edit-ingredients');
Route::delete('/delete-ingredient/{ingredient}', [App\Http\Controllers\ItemController::class, 'deleteIngredient'])->name('items.delete-ingredient');

Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'index'])->name('settings');
