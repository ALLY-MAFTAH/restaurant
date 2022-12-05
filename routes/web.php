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
Route::put('materials/{material}/status', [App\Http\Controllers\MaterialController::class, 'toggleStatus'])->name('materials.toggle-status');

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

// PRODUCTS ROUTES
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'postProduct'])->name('products.add');
Route::get('/show-product/{product}', [App\Http\Controllers\ProductController::class, 'showProduct'])->name('products.show');
Route::put('/edit-product/{product}', [App\Http\Controllers\ProductController::class, 'putProduct'])->name('products.edit');
Route::delete('/delete-product/{product}', [App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('products.delete');
Route::put('products/{product}/status', [App\Http\Controllers\ProductController::class, 'toggleStatus'])->name('products.toggle-status');

// USERS ROUTES
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/show-user/{user}', [App\Http\Controllers\UserController::class, 'showUser'])->name('users.show');
Route::post('/add-user', [App\Http\Controllers\UserController::class, 'postUser'])->name('users.add');
Route::put('users/{user}/status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::put('edit-user/{user}', [App\Http\Controllers\UserController::class, 'putUser'])->name('users.edit');
Route::delete('/delete-user/{user}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('users.delete');

// ROLES ROUTES
Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
Route::get('/show-role/{role}', [App\Http\Controllers\RoleController::class, 'showRole'])->name('roles.show');
Route::post('/add-role', [App\Http\Controllers\RoleController::class, 'postRole'])->name('roles.add');
Route::put('roles/{role}/status', [App\Http\Controllers\RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
Route::put('edit-role/{role}', [App\Http\Controllers\RoleController::class, 'putRole'])->name('roles.edit');
Route::delete('/delete-role/{role}', [App\Http\Controllers\RoleController::class, 'deleteRole'])->name('roles.delete');


Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings');
