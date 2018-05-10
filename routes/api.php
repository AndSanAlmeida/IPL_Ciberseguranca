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
	
Route::middleware('auth:api')->post('users', 'UserControllerAPI@getUsers'); //GET LIST OF USERS TO MANAGE
Route::middleware('auth:api')->post('usersForStatus', 'UserControllerAPI@getUsersForStatus'); //GET LIST OF USERS FOR STATUS TO MANAGE
Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@updateState'); //CHANGE STATE USER
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@delete'); //DELETE USER

Route::middleware('auth:api')->get('events', 'EventControllerAPI@index'); //GET LIST OF EVENTS
Route::middleware('auth:api')->get('events/{id}', 'EventControllerAPI@show'); // get event by id 
Route::middleware('auth:api')->post('events/create', 'EventControllerAPI@create'); // create event
Route::middleware('auth:api')->delete('event/{id}/delete', 'EventControllerAPI@destroy'); // delete event
Route::middleware('auth:api')->post('events/{id}/update', 'EventControllerAPI@edit'); // edit event

Route::middleware('auth:api')->get('glossary', 'GlossaryControllerAPI@index'); //Get the glossary
Route::middleware('auth:api')->get('glossary/{id}', 'GlossaryControllerAPI@show'); // get item of glossary by id 
Route::middleware('auth:api')->post('glossary/create', 'GlossaryControllerAPI@store'); // create item of glossary
Route::middleware('auth:api')->delete('glossary/{id}/delete', 'GlossaryControllerAPI@destroy'); // delete item of glossary
Route::middleware('auth:api')->post('glossary/{id}/update', 'GlossaryControllerAPI@update'); // edit item of glossary

Route::middleware('auth:api')->get('settings', 'ConfigControllerAPI@getPlatformData'); // get platform email
Route::middleware('auth:api')->post('settings/update', 'ConfigControllerAPI@update'); // update platform email
Route::middleware('auth:api')->get('settings/aboutUs', 'ConfigControllerAPI@getAboutUs'); // get about us
Route::middleware('auth:api')->post('settings/aboutUs/update', 'ConfigControllerAPI@aboutUsUpdate'); // update about us

Route::middleware('auth:api')->get('usefulLinks', 'UsefulLinksControllerAPI@index'); //Get the useful links
Route::middleware('auth:api')->get('usefulLinks/{id}', 'UsefulLinksControllerAPI@show'); // get item of useful links by id 
Route::middleware('auth:api')->post('usefulLinks/create', 'UsefulLinksControllerAPI@store'); // create item of useful links
Route::middleware('auth:api')->delete('usefulLinks/{id}/delete', 'UsefulLinksControllerAPI@destroy'); // delete item of useful links
Route::middleware('auth:api')->post('usefulLinks/{id}/update', 'UsefulLinksControllerAPI@update'); // edit item of useful links

Route::middleware('auth:api')->get('documents', 'DocumentsControllerAPI@index'); //Get the useful links
Route::middleware('auth:api')->get('documents/{id}', 'DocumentsControllerAPI@show'); // get item of useful links by id 
Route::middleware('auth:api')->post('documents/create', 'DocumentsControllerAPI@store'); // create item of useful links
Route::middleware('auth:api')->delete('documents/{id}/delete', 'DocumentsControllerAPI@destroy'); // delete item of useful links
Route::middleware('auth:api')->post('documents/{id}/update', 'DocumentsControllerAPI@update'); // edit item of useful links