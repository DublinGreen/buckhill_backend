<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['prefix'=> env('PREFIX'),'as'=>'user.'], function(){
    Route::get('user', UserController::class . '@index')->name('index');
    Route::delete('user/{id}', UserController::class . '@delete')->name('delete');
    Route::get('user/orders', UserController::class . '@orders')->name('orders');
    Route::post('user/create', UserController::class . '@create')->name('create');
    Route::post('user/forgot-password', UserController::class . '@forgotPassword')->name('forgotPassword');
    Route::post('user/login', UserController::class . '@login')->name('login');
    Route::get('user/logout', UserController::class . '@logout')->name('logout');
    Route::post('user/reset-password-token', UserController::class . '@resetPasswordToken')->name('resetPasswordToken');
    Route::put('user/edit', UserController::class . '@edit')->name('edit');
    
});