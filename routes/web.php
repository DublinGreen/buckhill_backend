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
Route::post(env('PREFIX') . 'admin/login', 'AdminController@login');
Route::get(env('PREFIX') . 'user/logout', 'UserController@logout');
Route::get(env('PREFIX') . 'admin/logout', 'AdminController@logout');


Route::group(['prefix'=> env('PREFIX'),'as'=>'user.','middleware' => ['auth']], function(){
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@getById');
    Route::delete('user/{id}', 'UserController@delete');
    Route::get('user/orders/{id}', 'UserController@orders');
    Route::put('user/edit/{id}', 'UserController@edit');
    Route::post('user/create', 'UserController@create');
    Route::post('user/forgot-password', 'UserController@forgotPassword');
    Route::post('user/reset-password-token', 'UserController@resetPasswordToken');

    Route::get('admin/user-listing', 'AdminController@index');
    Route::post('admin/create', 'AdminController@create');
    Route::post('admin/user-edit/{id}', 'AdminController@edit');
    Route::post('admin/user-delete/{id}', 'AdminController@delete');
});

// Route::post(env('PREFIX') . 'user/login', 'UserController@login')->middleware(Authenticate::class);
