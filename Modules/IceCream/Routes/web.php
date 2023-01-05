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
Route::prefix('icecream')->group(function () {

    Route::get('/', 'IcecreamController@index')->name('icecream.index');

    Route::namespace('Auth')->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('icecream.login');
        Route::post('/login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('icecream.logout');
        Route::get('/reset-password', 'ResetPasswordController@index')->name('icecream.password.request');
        Route::post('/send-reset-link', 'ResetPasswordController@validatePasswordRequest')->name('icecream.password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@reset')->name('icecream.password.reset');
        Route::post('/password/reset-confirm', 'ResetPasswordController@resetPassword')->name('icecream.password.update');
    });

    Route::middleware(['auth:icecream'])->group(function () {

        // STOCK ROUTES
        Route::get('/stocks', [StockController::class, 'index'])->name('icecream.stocks.index');
        Route::post('/add-stock', [StockController::class, 'postStock'])->name('icecream.stocks.add');
        Route::get('/show-stock/{stock}', [StockController::class, 'showStock'])->name('icecream.stocks.show');
        Route::put('/edit-stock/{stock}', [StockController::class, 'putStock'])->name('icecream.stocks.edit');
        Route::delete('/delete-stock/{stock}', [StockController::class, 'deleteStock'])->name('icecream.stocks.delete');
        Route::put('stocks/{stock}/status', [StockController::class, 'toggleStatus'])->name('icecream.stocks.toggle-status');

        // ITEM ROUTES
        Route::get('/items', [ItemController::class, 'index'])->name('icecream.items.index');
        Route::post('/add-item', [ItemController::class, 'postItem'])->name('icecream.items.add');
        Route::get('/show-item/{item}', [ItemController::class, 'showItem'])->name('icecream.items.show');
        Route::put('/edit-item/{item}', [ItemController::class, 'putItem'])->name('icecream.items.edit');
        Route::delete('/delete-item/{item}', [ItemController::class, 'deleteItem'])->name('icecream.items.delete');
        Route::put('items/{item}/status', [ItemController::class, 'toggleStatus'])->name('icecream.items.toggle-status');
        Route::post('/add-ingredients/{item}', [ItemController::class, 'postIngredients'])->name('icecream.items.add-ingredients');
        Route::put('/edit-ingredients/{item}', [ItemController::class, 'putIngredients'])->name('icecream.items.edit-ingredients');
        Route::delete('/delete-ingredient/{ingredient}', [ItemController::class, 'deleteIngredient'])->name('icecream.items.delete-ingredient');

        // PRODUCTS ROUTES
        Route::get('/products', [ProductController::class, 'index'])->name('icecream.products.index');
        Route::post('/add-product', [ProductController::class, 'postProduct'])->name('icecream.products.add');
        Route::get('/show-product/{product}', [ProductController::class, 'showProduct'])->name('icecream.products.show');
        Route::put('/edit-product/{product}', [ProductController::class, 'putProduct'])->name('icecream.products.edit');
        Route::delete('/delete-product/{product}', [ProductController::class, 'deleteProduct'])->name('icecream.products.delete');
        Route::put('products/{product}/status', [ProductController::class, 'toggleStatus'])->name('icecream.products.toggle-status');

        // USERS ROUTES
        Route::get('/icecreams', [UserController::class, 'index'])->name('icecreams.index');
        Route::get('/show-icecream/{icecream}', [UserController::class, 'showUser'])->name('icecreams.show');
        Route::post('/add-icecream', [UserController::class, 'postUser'])->name('icecreams.add');
        Route::put('icecreams/{icecream}/status', [UserController::class, 'toggleStatus'])->name('icecreams.toggle-status');
        Route::put('edit-icecream/{icecream}', [UserController::class, 'putUser'])->name('icecreams.edit');
        Route::delete('/delete-icecream/{icecream}', [UserController::class, 'deleteUser'])->name('icecreams.delete');

        // ROLES ROUTES
        Route::get('/roles', [RoleController::class, 'index'])->name('icecream.roles.index');
        Route::get('/show-role/{role}', [RoleController::class, 'showRole'])->name('icecream.roles.show');
        Route::post('/add-role', [RoleController::class, 'postRole'])->name('icecream.roles.add');
        Route::put('roles/{role}/status', [RoleController::class, 'toggleStatus'])->name('icecream.roles.toggle-status');
        Route::put('edit-role/{role}', [RoleController::class, 'putRole'])->name('icecream.roles.edit');
        Route::delete('/delete-role/{role}', [RoleController::class, 'deleteRole'])->name('icecream.roles.delete');

        // SALES ROUTES
        Route::get('/sales', [SaleController::class, 'index'])->name('icecream.sales.index');
        Route::post('/sell-product/{product}', [SaleController::class, 'sellProduct'])->name('icecream.products.sell');

        // SETTINGS ROUTES
        Route::get('/settings', [SettingController::class, 'index'])->name('icecream.settings.index');
        Route::put('/edit-setting', [SettingController::class, 'putSetting'])->name('icecream.settings.edit');
        Route::post('/add-setting', [SettingController::class, 'postSetting'])->name('icecream.settings.add');
        Route::delete('/delete-setting/{key}', [SettingController::class, 'deleteSetting'])->name('icecream.settings.delete');

        // ACTIVITY LOGS ROUTES
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('icecream.logs.index');
        Route::post('/add-log', [ActivityLogController::class, 'postActivityLog'])->name('icecream.logs.add');
        Route::put('/edit-log', [ActivityLogController::class, 'putActivityLog'])->name('icecream.logs.edit');
        Route::delete('/delete-log/{key}', [ActivityLogController::class, 'deleteActivityLog'])->name('icecream.logs.delete');

        // REPORTS ROUTES
        Route::get('/reports', [ReportController::class, 'index'])->name('icecream.reports.index');
    });
});
