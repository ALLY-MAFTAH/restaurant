<?php

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
namespace Modules\Icecream\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::prefix('icecream')->group(function() {
    Route::get('/', 'IceCreamController@index');


// Route::get('/', function () {
//     return view('login');
// });
// Route::redirect('/', '/dashboard');


Route::get('/dashboard', [Modules\Icecream\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// STOCK ROUTES
// Route::get('/', 'IceCreamController@index');
Route::get('/stocks','StockController@index')->name('stocks.index');
// Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::post('/add-stock', [Modules\Icecream\Http\Controllers\StockController::class, 'postStock'])->name('stocks.add');
Route::get('/show-stock/{stock}', [Modules\Icecream\Http\Controllers\StockController::class, 'showStock'])->name('stocks.show');
Route::put('/edit-stock/{stock}', [Modules\Icecream\Http\Controllers\StockController::class, 'putStock'])->name('stocks.edit');
Route::delete('/delete-stock/{stock}', [Modules\Icecream\Http\Controllers\StockController::class, 'deleteStock'])->name('stocks.delete');
Route::put('stocks/{stock}/status', [Modules\Icecream\Http\Controllers\StockController::class, 'toggleStatus'])->name('stocks.toggle-status');

// ITEM ROUTES
Route::get('/items', [Modules\Icecream\Http\Controllers\ItemController::class, 'index'])->name('items.index');
Route::post('/add-item', [Modules\Icecream\Http\Controllers\ItemController::class, 'postItem'])->name('items.add');
Route::get('/show-item/{item}', [Modules\Icecream\Http\Controllers\ItemController::class, 'showItem'])->name('items.show');
Route::put('/edit-item/{item}', [Modules\Icecream\Http\Controllers\ItemController::class, 'putItem'])->name('items.edit');
Route::delete('/delete-item/{item}', [Modules\Icecream\Http\Controllers\ItemController::class, 'deleteItem'])->name('items.delete');
Route::put('items/{item}/status', [Modules\Icecream\Http\Controllers\ItemController::class, 'toggleStatus'])->name('items.toggle-status');
Route::post('/add-ingredients/{item}', [Modules\Icecream\Http\Controllers\ItemController::class, 'postIngredients'])->name('items.add-ingredients');
Route::put('/edit-ingredients/{item}', [Modules\Icecream\Http\Controllers\ItemController::class, 'putIngredients'])->name('items.edit-ingredients');
Route::delete('/delete-ingredient/{ingredient}', [Modules\Icecream\Http\Controllers\ItemController::class, 'deleteIngredient'])->name('items.delete-ingredient');

// PRODUCTS ROUTES
Route::get('/products', [Modules\Icecream\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('/add-product', [Modules\Icecream\Http\Controllers\ProductController::class, 'postProduct'])->name('products.add');
Route::get('/show-product/{product}', [Modules\Icecream\Http\Controllers\ProductController::class, 'showProduct'])->name('products.show');
Route::put('/edit-product/{product}', [Modules\Icecream\Http\Controllers\ProductController::class, 'putProduct'])->name('products.edit');
Route::delete('/delete-product/{product}', [Modules\Icecream\Http\Controllers\ProductController::class, 'deleteProduct'])->name('products.delete');
Route::put('products/{product}/status', [Modules\Icecream\Http\Controllers\ProductController::class, 'toggleStatus'])->name('products.toggle-status');

// USERS ROUTES
Route::get('/users', [Modules\Icecream\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/show-user/{user}', [Modules\Icecream\Http\Controllers\UserController::class, 'showUser'])->name('users.show');
Route::post('/add-user', [Modules\Icecream\Http\Controllers\UserController::class, 'postUser'])->name('users.add');
Route::put('users/{user}/status', [Modules\Icecream\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::put('edit-user/{user}', [Modules\Icecream\Http\Controllers\UserController::class, 'putUser'])->name('users.edit');
Route::delete('/delete-user/{user}', [Modules\Icecream\Http\Controllers\UserController::class, 'deleteUser'])->name('users.delete');

// ROLES ROUTES
Route::get('/roles', [Modules\Icecream\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
Route::get('/show-role/{role}', [Modules\Icecream\Http\Controllers\RoleController::class, 'showRole'])->name('roles.show');
Route::post('/add-role', [Modules\Icecream\Http\Controllers\RoleController::class, 'postRole'])->name('roles.add');
Route::put('roles/{role}/status', [Modules\Icecream\Http\Controllers\RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
Route::put('edit-role/{role}', [Modules\Icecream\Http\Controllers\RoleController::class, 'putRole'])->name('roles.edit');
Route::delete('/delete-role/{role}', [Modules\Icecream\Http\Controllers\RoleController::class, 'deleteRole'])->name('roles.delete');

// SALES ROUTES
Route::get('/sales', [Modules\Icecream\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
Route::post('/sell-product/{product}', [Modules\Icecream\Http\Controllers\SaleController::class, 'sellProduct'])->name('products.sell');

// SETTINGS ROUTES
Route::get('/settings', [Modules\Icecream\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
Route::put('/edit-setting', [Modules\Icecream\Http\Controllers\SettingController::class, 'putSetting'])->name('settings.edit');
Route::post('/add-setting', [Modules\Icecream\Http\Controllers\SettingController::class, 'postSetting'])->name('settings.add');
Route::delete('/delete-setting/{key}', [Modules\Icecream\Http\Controllers\SettingController::class, 'deleteSetting'])->name('settings.delete');

// ACTIVITY LOGS ROUTES
Route::get('/logs', [Modules\Icecream\Http\Controllers\ActivityLogController::class, 'index'])->name('logs.index');
Route::post('/add-log', [Modules\Icecream\Http\Controllers\ActivityLogController::class, 'postActivityLog'])->name('logs.add');
Route::put('/edit-log', [Modules\Icecream\Http\Controllers\ActivityLogController::class, 'putActivityLog'])->name('logs.edit');
Route::delete('/delete-log/{key}', [Modules\Icecream\Http\Controllers\ActivityLogController::class, 'deleteActivityLog'])->name('logs.delete');

// REPORTS ROUTES
Route::get('/reports', [Modules\Icecream\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

});
