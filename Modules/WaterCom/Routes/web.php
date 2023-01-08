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

namespace Modules\Watercom\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::prefix('watercom')->group(function () {

    Route::get('/', 'WatercomController@index')->name('watercom.index');

    Route::namespace('Auth')->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('watercom.login');
        Route::post('/login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('watercom.logout');
        Route::get('/reset-password', 'ResetPasswordController@index')->name('watercom.password.request');
        Route::post('/send-reset-link', 'ResetPasswordController@validatePasswordRequest')->name('watercom.password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@reset')->name('watercom.password.reset');
        Route::post('/password/reset-confirm', 'ResetPasswordController@resetPassword')->name('watercom.password.update');
    });

    Route::middleware(['auth:watercom'])->group(function () {

        // STOCK ROUTES
        Route::get('/stocks', [WatercomStockController::class, 'index'])->name('watercom.stocks.index');
        Route::post('/add-stock', [WatercomStockController::class, 'postWatercomStock'])->name('watercom.stocks.add');
        Route::get('/show-stock/{stock}', [WatercomStockController::class, 'showWatercomStock'])->name('watercom.stocks.show');
        Route::put('/edit-stock/{stock}', [WatercomStockController::class, 'putWatercomStock'])->name('watercom.stocks.edit');
        Route::delete('/delete-stock/{stock}', [WatercomStockController::class, 'deleteWatercomStock'])->name('watercom.stocks.delete');
        Route::put('stocks/{stock}/status', [WatercomStockController::class, 'toggleStatus'])->name('watercom.stocks.toggle-status');

        // ITEM ROUTES
        Route::get('/items', [ItemController::class, 'index'])->name('watercom.items.index');
        Route::post('/add-item', [ItemController::class, 'postItem'])->name('watercom.items.add');
        Route::get('/show-item/{item}', [ItemController::class, 'showItem'])->name('watercom.items.show');
        Route::put('/edit-item/{item}', [ItemController::class, 'putItem'])->name('watercom.items.edit');
        Route::delete('/delete-item/{item}', [ItemController::class, 'deleteItem'])->name('watercom.items.delete');
        Route::put('items/{item}/status', [ItemController::class, 'toggleStatus'])->name('watercom.items.toggle-status');
        Route::post('/add-ingredients/{item}', [ItemController::class, 'postIngredients'])->name('watercom.items.add-ingredients');
        Route::put('/edit-ingredients/{item}', [ItemController::class, 'putIngredients'])->name('watercom.items.edit-ingredients');
        Route::delete('/delete-ingredient/{ingredient}', [ItemController::class, 'deleteIngredient'])->name('watercom.items.delete-ingredient');

        // PRODUCTS ROUTES
        Route::get('/products', [WatercomProductController::class, 'index'])->name('watercom.products.index');
        Route::post('/add-product', [WatercomProductController::class, 'postWatercomProduct'])->name('watercom.products.add');
        Route::get('/show-product/{product}', [WatercomProductController::class, 'showWatercomProduct'])->name('watercom.products.show');
        Route::put('/edit-product/{product}', [WatercomProductController::class, 'putWatercomProduct'])->name('watercom.products.edit');
        Route::delete('/delete-product/{product}', [WatercomProductController::class, 'deleteWatercomProduct'])->name('watercom.products.delete');
        Route::put('products/{product}/status', [WatercomProductController::class, 'toggleStatus'])->name('watercom.products.toggle-status');

        // USERS ROUTES
        Route::get('/watercoms', [UserController::class, 'index'])->name('watercoms.index');
        Route::get('/show-watercom/{watercom}', [UserController::class, 'showUser'])->name('watercoms.show');
        Route::post('/add-watercom', [UserController::class, 'postUser'])->name('watercoms.add');
        Route::put('watercoms/{watercom}/status', [UserController::class, 'toggleStatus'])->name('watercoms.toggle-status');
        Route::put('edit-watercom/{watercom}', [UserController::class, 'putUser'])->name('watercoms.edit');
        Route::delete('/delete-watercom/{watercom}', [UserController::class, 'deleteUser'])->name('watercoms.delete');

        // ROLES ROUTES
        Route::get('/roles', [RoleController::class, 'index'])->name('watercom.roles.index');
        Route::get('/show-role/{role}', [RoleController::class, 'showRole'])->name('watercom.roles.show');
        Route::post('/add-role', [RoleController::class, 'postRole'])->name('watercom.roles.add');
        Route::put('roles/{role}/status', [RoleController::class, 'toggleStatus'])->name('watercom.roles.toggle-status');
        Route::put('edit-role/{role}', [RoleController::class, 'putRole'])->name('watercom.roles.edit');
        Route::delete('/delete-role/{role}', [RoleController::class, 'deleteRole'])->name('watercom.roles.delete');

        // SALES ROUTES
        Route::get('/sales', [WatercomSaleController::class, 'index'])->name('watercom.sales.index');
        Route::post('/sell-product/{product}', [WatercomSaleController::class, 'sellWatercomProduct'])->name('watercom.products.sell');

        // SETTINGS ROUTES
        Route::get('/settings', [SettingController::class, 'index'])->name('watercom.settings.index');
        Route::put('/edit-setting', [SettingController::class, 'putSetting'])->name('watercom.settings.edit');
        Route::post('/add-setting', [SettingController::class, 'postSetting'])->name('watercom.settings.add');
        Route::delete('/delete-setting/{key}', [SettingController::class, 'deleteSetting'])->name('watercom.settings.delete');

        // ACTIVITY LOGS ROUTES
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('watercom.logs.index');
        Route::post('/add-log', [ActivityLogController::class, 'postActivityLog'])->name('watercom.logs.add');
        Route::put('/edit-log', [ActivityLogController::class, 'putActivityLog'])->name('watercom.logs.edit');
        Route::delete('/delete-log/{key}', [ActivityLogController::class, 'deleteActivityLog'])->name('watercom.logs.delete');

        // REPORTS ROUTES
        Route::get('/reports', [ReportController::class, 'index'])->name('watercom.reports.index');
    });
});
