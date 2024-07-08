<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\SupplyController;
// use App\Http\Controllers\ResponsibilityController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\ToolController;
use App\Http\Middleware\Authenticate;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::post(env('PREFIX') . 'user/login', 'UserController@login');


Route::group(['prefix'=> env('PREFIX'),'as'=>'user.','middleware' => ['auth']], function(){
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@getById');
    Route::delete('user/{id}', 'UserController@delete');
    Route::get('user/orders/{id}', 'UserController@orders');
    Route::put('user/edit/{id}', 'UserController@edit');
    // Route::post('user/login', 'UserController@login');

    // Route::post('user/forgot-password', UserController::class . '@forgotPassword')->name('forgotPassword');
    // Route::post('user/login', UserController::class . '@login')->name('login');
    // Route::get('user/logout', UserController::class . '@logout')->name('logout');
    // Route::post('user/reset-password-token', UserController::class . '@resetPasswordToken')->name('resetPasswordToken');
    
});

// Route::post(env('PREFIX') . 'user/login', 'UserController@login')->middleware(Authenticate::class);
