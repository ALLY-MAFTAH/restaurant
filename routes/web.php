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
Route::get('/materials', [App\Http\Controllers\MaterialController::class, 'index'])->name('materials');
Route::post('/add-material', [App\Http\Controllers\MaterialController::class, 'postMaterial'])->name('add-material');
Route::put('/edit-material/{material}', [App\Http\Controllers\MaterialController::class, 'putMaterial'])->name('edit-material');
Route::delete('/delete-material/{material}', [App\Http\Controllers\MaterialController::class, 'deleteMaterial'])->name('delete-material');
Route::put('materials/{material}/status', [App\Http\Controllers\MaterialController::class, 'toggleStatus'])->name('materials.toggle_status');


Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales');
Route::get('/items', [App\Http\Controllers\ItemController::class, 'index'])->name('items');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/settings', [App\Http\Controllers\UserController::class, 'index'])->name('settings');
