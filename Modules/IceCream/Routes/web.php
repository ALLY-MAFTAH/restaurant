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
namespace Modules\IceCream\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('icecream')->group(function() {
    Route::get('/', 'IceCreamController@index');


Route::get('/', function () {
    return view('login');
});
Route::redirect('/', '/dashboard');

Auth::routes();

Route::get('/dashboard', [IceCreamController::class, 'index'])->name('dashboard');

// STOCK ROUTES
// Route::get('/stocks','AgentController@index')->name('stocks.index');
Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::post('/add-stock', [StockController::class, 'postStock'])->name('stocks.add');
Route::get('/show-stock/{stock}', [StockController::class, 'showStock'])->name('stocks.show');
Route::put('/edit-stock/{stock}', [StockController::class, 'putStock'])->name('stocks.edit');
Route::delete('/delete-stock/{stock}', [StockController::class, 'deleteStock'])->name('stocks.delete');
Route::put('stocks/{stock}/status', [StockController::class, 'toggleStatus'])->name('stocks.toggle-status');

// ITEM ROUTES
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/add-item', [ItemController::class, 'postItem'])->name('items.add');
Route::get('/show-item/{item}', [ItemController::class, 'showItem'])->name('items.show');
Route::put('/edit-item/{item}', [ItemController::class, 'putItem'])->name('items.edit');
Route::delete('/delete-item/{item}', [ItemController::class, 'deleteItem'])->name('items.delete');
Route::put('items/{item}/status', [ItemController::class, 'toggleStatus'])->name('items.toggle-status');
Route::post('/add-ingredients/{item}', [ItemController::class, 'postIngredients'])->name('items.add-ingredients');
Route::put('/edit-ingredients/{item}', [ItemController::class, 'putIngredients'])->name('items.edit-ingredients');
Route::delete('/delete-ingredient/{ingredient}', [ItemController::class, 'deleteIngredient'])->name('items.delete-ingredient');

// PRODUCTS ROUTES
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/add-product', [ProductController::class, 'postProduct'])->name('products.add');
Route::get('/show-product/{product}', [ProductController::class, 'showProduct'])->name('products.show');
Route::put('/edit-product/{product}', [ProductController::class, 'putProduct'])->name('products.edit');
Route::delete('/delete-product/{product}', [ProductController::class, 'deleteProduct'])->name('products.delete');
Route::put('products/{product}/status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');

// USERS ROUTES
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/show-user/{user}', [UserController::class, 'showUser'])->name('users.show');
Route::post('/add-user', [UserController::class, 'postUser'])->name('users.add');
Route::put('users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::put('edit-user/{user}', [UserController::class, 'putUser'])->name('users.edit');
Route::delete('/delete-user/{user}', [UserController::class, 'deleteUser'])->name('users.delete');

// ROLES ROUTES
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/show-role/{role}', [RoleController::class, 'showRole'])->name('roles.show');
Route::post('/add-role', [RoleController::class, 'postRole'])->name('roles.add');
Route::put('roles/{role}/status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
Route::put('edit-role/{role}', [RoleController::class, 'putRole'])->name('roles.edit');
Route::delete('/delete-role/{role}', [RoleController::class, 'deleteRole'])->name('roles.delete');

// SALES ROUTES
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::post('/sell-product/{product}', [SaleController::class, 'sellProduct'])->name('products.sell');

// SETTINGS ROUTES
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/edit-setting', [SettingController::class, 'putSetting'])->name('settings.edit');
Route::post('/add-setting', [SettingController::class, 'postSetting'])->name('settings.add');
Route::delete('/delete-setting/{key}', [SettingController::class, 'deleteSetting'])->name('settings.delete');

// ACTIVITY LOGS ROUTES
Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
Route::post('/add-log', [ActivityLogController::class, 'postActivityLog'])->name('logs.add');
Route::put('/edit-log', [ActivityLogController::class, 'putActivityLog'])->name('logs.edit');
Route::delete('/delete-log/{key}', [ActivityLogController::class, 'deleteActivityLog'])->name('logs.delete');

// REPORTS ROUTES
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

});
