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

Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@updateState'); //CHANGE STATE USER
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@delete'); //DELETE USER
Route::middleware('auth:api')->get('user/{id}', 'UserControllerAPI@getUserById'); // get user by id

Route::get('events', 'EventControllerAPI@index'); //GET LIST OF EVENTS
Route::get('events/{id}', 'EventControllerAPI@show'); // get event by id 
Route::middleware('auth:api')->post('events/create', 'EventControllerAPI@create'); // create event
Route::middleware('auth:api')->delete('event/{id}/delete', 'EventControllerAPI@destroy'); // delete event
Route::middleware('auth:api')->post('events/{id}/update', 'EventControllerAPI@edit'); // edit event
Route::middleware('auth:api')->post('events/subscribe', 'EventControllerAPI@subscribe'); // subscribe to event

Route::get('glossary/byLetter/{letter}', 'GlossaryControllerAPI@getGlossaryItensByLetter'); //Get the glossary by letter
Route::get('glossary/letters', 'GlossaryControllerAPI@getLetterInGlossary'); // get all letter in glossary
Route::get('glossary', 'GlossaryControllerAPI@index'); //Get the glossary
Route::get('glossary/{id}', 'GlossaryControllerAPI@show'); // get item of glossary by id 
Route::middleware('auth:api')->post('glossary/create', 'GlossaryControllerAPI@store'); // create item of glossary
Route::middleware('auth:api')->delete('glossary/{id}/delete', 'GlossaryControllerAPI@destroy'); // delete item of glossary
Route::middleware('auth:api')->post('glossary/{id}/update', 'GlossaryControllerAPI@update'); // edit item of glossary

Route::middleware('auth:api')->get('settings', 'ConfigControllerAPI@getPlatformData'); // get platform email
Route::middleware('auth:api')->post('settings/update', 'ConfigControllerAPI@update'); // update platform email
Route::get('settings/aboutUs', 'ConfigControllerAPI@getAboutUs'); // get about us
Route::middleware('auth:api')->post('settings/aboutUs/update', 'ConfigControllerAPI@aboutUsUpdate'); // update about us
Route::get('settings/activities', 'ConfigControllerAPI@getActivities'); // get about us
Route::middleware('auth:api')->post('settings/activities/update', 'ConfigControllerAPI@ActivitiesUpdate'); // update about us
Route::get('settings/resources', 'ConfigControllerAPI@getResources'); // get about us
Route::middleware('auth:api')->post('settings/resources/update', 'ConfigControllerAPI@ResourcesUpdate'); // update about us

Route::get('usefulLinks', 'UsefulLinksControllerAPI@index'); //Get the useful links
Route::get('usefulLinks/{id}', 'UsefulLinksControllerAPI@show'); // get item of useful links by id 
Route::middleware('auth:api')->post('usefulLinks/create', 'UsefulLinksControllerAPI@store'); // create item of useful links
Route::middleware('auth:api')->delete('usefulLinks/{id}/delete', 'UsefulLinksControllerAPI@destroy'); // delete item of useful links
Route::middleware('auth:api')->post('usefulLinks/{id}/update', 'UsefulLinksControllerAPI@update'); // edit item of useful links

Route::get('documents', 'DocumentsControllerAPI@index'); //Get the useful links
Route::get('documents/{id}', 'DocumentsControllerAPI@show'); // get item of useful links by id 
Route::middleware('auth:api')->post('documents/create', 'DocumentsControllerAPI@store'); // create item of useful links
Route::middleware('auth:api')->delete('documents/{id}/delete', 'DocumentsControllerAPI@destroy'); // delete item of useful links
Route::middleware('auth:api')->post('documents/{id}/update', 'DocumentsControllerAPI@update'); // edit item of useful links

Route::get('newsletters', 'NewsletterControllerAPI@index'); // get all newsletter
Route::get('newsletters/{id}', 'NewsletterControllersAPI@show'); // get newsletter
Route::middleware('auth:api')->post('newsletters/create', 'NewsletterControllerAPI@store'); // create newsletter
Route::middleware('auth:api')->delete('newsletters/{id}/delete', 'NewsletterControllerAPI@destroy'); // delete newsletter
Route::middleware('auth:api')->post('newsletters/{id}/update', 'NewsletterControllerAPI@update'); // edit newsletter
Route::post('newsletter/subscribe', 'NewsletterControllerAPI@subscribe'); // subscribe to newsletter
Route::delete('newsletter/{email}/unsubcribe', 'NewsletterControllerAPI@unsubscribe'); // delete subscription of newsletter
Route::post('newsletter/subscribed', 'NewsletterControllerAPI@subscribed'); // check if user is in newsletter subscription
Route::middleware('auth:api')->post('newsletters/{id}/publish', 'NewsletterControllerAPI@publish'); // edit newsletter

Route::middleware('auth:api')->post('questions/create', 'UserQuestionControllerAPI@store'); // edit newsletter
Route::middleware('auth:api')->get('questions', 'UserQuestionControllerAPI@index'); // get all questions
Route::middleware('auth:api')->get('questions/answered', 'UserQuestionControllerAPI@answered'); // get all questions
Route::middleware('auth:api')->get('questions/notAnswered', 'UserQuestionControllerAPI@notAnswered'); // get questions with no answered
Route::middleware('auth:api')->delete('questions/{id}/delete', 'UserQuestionControllerAPI@deleteQuestion'); // delete question
Route::middleware('auth:api')->post('questions/answer', 'UserQuestionControllerAPI@answer'); // responde to a question

Route::get('faqs', 'FAQControllerAPI@index'); //Get faqs
Route::get('faqs/{id}', 'FAQControllerAPI@show'); // get faq by id 
Route::middleware('auth:api')->post('faqs/create/clean', 'FAQControllerAPI@cleanStore'); // create clean faq 
Route::middleware('auth:api')->post('faqs/create', 'FAQControllerAPI@store'); // create faq from user question
Route::middleware('auth:api')->delete('faqs/{id}/delete', 'FAQControllerAPI@destroy'); // delete faq
Route::middleware('auth:api')->post('faqs/{id}/update', 'FAQControllerAPI@update'); // edit faq

Route::get('rssNews', 'RSSNewsControllerAPI@index'); // get rss news
Route::middleware('auth:api')->post('rssNews/create', 'RSSNewsControllerAPI@store'); // add rss of news
Route::middleware('auth:api')->delete('rssNews/{id}/delete', 'RSSNewsControllerAPI@destroy'); // delete rss of news
Route::get('rssNews/{id}', 'RSSNewsControllerAPI@show'); // get rss by id
Route::middleware('auth:api')->post('rssNews/{id}/update', 'RSSNewsControllerAPI@update'); // edit rss 

Route::middleware('auth:api')->post('news/create', 'NewsControllerAPI@store'); // add rss of news
Route::get('news', 'NewsControllerAPI@index');
/******************
	USER ROUTES
 *****************/
	
Route::middleware('auth:api')->post('users', 'UserControllerAPI@getUsers'); //GET LIST OF USERS TO MANAGE
Route::middleware('auth:api')->post('usersForStatus', 'UserControllerAPI@getUsersForStatus'); //GET LIST OF USERS FOR STATUS TO MANAGE
Route::middleware('auth:api')->post('/user/update', 'UserControllerAPI@updateUserSettings'); //UPDATE USER INFO
Route::middleware('auth:api')->delete('deleteOwnAccount', 'UserControllerAPI@deleteOwnAccount'); //DELETE USER

/******************
 USER/ADMIN ROUTES
 *****************/

Route::middleware('auth:api')->post('/user/avatar/update', 'UserControllerAPI@updateAvatar'); //UPDATE AVATAR
Route::middleware('auth:api')->post('/user/password/update', 'UserControllerAPI@updatePassword'); //UPDATE PASSWORD

