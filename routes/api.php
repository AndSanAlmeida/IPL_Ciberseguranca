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


/******************
 LOGIN AND LOGOUT
 *****************/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserControllerAPI@store');
Route::post('login', 'LoginControllerAPI@login');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
Route::post('password/email', 'LoginControllerAPI@sendResetLinkEmail');
Route::post('password/reset', 'LoginControllerAPI@resetPassword');


/******************
	ADMIN ROUTES
 *****************/
	
Route::middleware('auth:api')->get('users', 'UserControllerAPI@getUsers'); //GET LIST OF USERS TO MANAGE
Route::middleware('auth:api')->get('events', 'EventControllerAPI@index'); //GET LIST OF EVENTS
Route::middleware('auth:api')->get('events/{id}', 'EventControllerAPI@show'); // get event by id 
Route::middleware('auth:api')->post('events/create', 'EventControllerAPI@create'); // create event
Route::middleware('auth:api')->delete('event/{id}/delete', 'EventControllerAPI@destroy'); // delete event
Route::middleware('auth:api')->post('events/{id}/update', 'EventControllerAPI@edit'); // edit event
