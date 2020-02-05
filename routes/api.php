<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('expenses', 'API\ExpensesController');
Route::get('user/getRole/{id}', 'API\UserController@getRole');


Route::resource('user', 'API\UserController');
Route::resource('roles', 'API\RoleController');
Route::resource('categories', 'API\ExpenseCategoriesController');

Route::post('changepassword', 'API\UserController@changePassword');