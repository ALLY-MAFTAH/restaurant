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
namespace Modules\Gas\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('gas_user')->group(function(){
    Route::get('/', 'GasController@index')->name('gas_user.index');
    Route::namespace('Auth')->group(function(){
    Route::get('/login', 'LoginController@showLoginForm')->name('gas_user.login');
    Route::post('/login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('gas_user.logout');
    });
   });
