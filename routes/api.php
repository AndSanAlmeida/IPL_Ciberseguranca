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

Route::group(['middleware' => 'prevent-back-history'],function(){
	Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
	Route::get('/', function() {
		return view('vue.index');
	});
});

Route::post('register', 'UserControllerAPI@store');
Route::post('login', 'LoginControllerAPI@login');
Route::post('password/email', 'LoginControllerAPI@sendResetLinkEmail');
Route::post('password/reset', 'LoginControllerAPI@resetPassword');

/******************
	ADMIN ROUTES
 *****************/

//  ==== USERS
//  ======================
Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@updateState'); //CHANGE STATE USER
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@delete'); //DELETE USER
Route::middleware('auth:api')->get('user/{id}', 'UserControllerAPI@getUserById'); // GET USER BY ID

//  ==== EVENTS
//  ======================
Route::get('events', 'EventControllerAPI@index'); //GET LIST OF EVENTS
Route::get('events/{id}', 'EventControllerAPI@show'); // GET EVENT BY ID
Route::middleware(['auth:api','isAdmin'])->post('events/create', 'EventControllerAPI@create'); // CREATE EVENT
Route::middleware('auth:api')->delete('event/{id}/delete', 'EventControllerAPI@destroy'); // DELETE EVENT
Route::middleware('auth:api')->post('events/{id}/update', 'EventControllerAPI@edit'); // EDIT EVENT
Route::middleware('auth:api')->post('events/subscribe', 'EventControllerAPI@subscribe'); // SUBSCRIBE TO EVENT

//  ==== GLOSSARY
//  ======================
Route::get('glossary/byLetter/{letter}', 'GlossaryControllerAPI@getGlossaryItensByLetter'); // GET GLOSSARY BY LETTER
Route::get('glossary/letters', 'GlossaryControllerAPI@getLetterInGlossary'); // GET ALL LETTERS IN GLOSSARY
Route::get('glossary', 'GlossaryControllerAPI@index'); // GET GLOSSARY
Route::get('glossary/{id}', 'GlossaryControllerAPI@show'); // GET ITEM FROM GLOSSARY BY ID
Route::middleware('auth:api')->post('glossary/create', 'GlossaryControllerAPI@store'); // CREATE ITEM OF GLOSSARY
Route::middleware('auth:api')->delete('glossary/{id}/delete', 'GlossaryControllerAPI@destroy'); // DELETE ITEM OF GLOSSARY
Route::middleware('auth:api')->post('glossary/{id}/update', 'GlossaryControllerAPI@update'); // EDIT ITEM OF GLOSSARY

//  ==== SETTINGS
//  ======================
Route::middleware('auth:api')->get('settings', 'ConfigControllerAPI@getPlatformData'); // GET PLATFORM EMAIL
Route::middleware('auth:api')->post('settings/update', 'ConfigControllerAPI@update'); // UPDATE PLATFORM EMAIL
Route::get('settings/ourMission', 'ConfigControllerAPI@getOurMission'); // GET OUR MISSION
Route::middleware('auth:api')->post('settings/ourMission/update', 'ConfigControllerAPI@ourMissionUpdate'); // UPDATE OUR MISSION
Route::get('settings/aboutUs', 'ConfigControllerAPI@getAboutUs'); // GET ABOUT US
Route::middleware('auth:api')->post('settings/aboutUs/update', 'ConfigControllerAPI@aboutUsUpdate'); // UPDATE ABOUT US
Route::get('settings/activities', 'ConfigControllerAPI@getActivities'); // GET ACTIVITIES
Route::middleware('auth:api')->post('settings/activities/update', 'ConfigControllerAPI@ActivitiesUpdate'); // UPDATE ACTIVITIES
Route::get('settings/resources', 'ConfigControllerAPI@getResources'); // GET RESOURCES
Route::middleware('auth:api')->post('settings/resources/update', 'ConfigControllerAPI@ResourcesUpdate'); // UPDATE RESOURCES

//  ==== USEFULL LINKS
//  ======================
Route::get('usefulLinks', 'UsefulLinksControllerAPI@index'); // GET USERFULL LINKS
Route::get('usefulLinks/{id}', 'UsefulLinksControllerAPI@show'); // GET ITEM OF USEFULL LINK BY ID
Route::middleware('auth:api')->post('usefulLinks/create', 'UsefulLinksControllerAPI@store'); // CREATE ITEM OF USEFULL LINK
Route::middleware('auth:api')->delete('usefulLinks/{id}/delete', 'UsefulLinksControllerAPI@destroy'); // DELETE ITEM OF USEFULL LINK
Route::middleware('auth:api')->post('usefulLinks/{id}/update', 'UsefulLinksControllerAPI@update'); // EDIT ITEM OF USEFULL LINK

//  ==== DOCUMENTS
//  ======================
Route::get('documents', 'DocumentsControllerAPI@index'); // GET DOCUMENTS
Route::get('documents/{id}', 'DocumentsControllerAPI@show'); //GET ITEM OF DOCUMENT BY ID
Route::middleware('auth:api')->post('documents/create', 'DocumentsControllerAPI@store'); // CREATE ITEM OF DOCUMENTS
Route::middleware('auth:api')->delete('documents/{id}/delete', 'DocumentsControllerAPI@destroy'); // DELETE ITEM OF DOCUMENTS
Route::middleware('auth:api')->post('documents/{id}/update', 'DocumentsControllerAPI@update'); // EDIT ITEM OF DOCUMENTS

//  ==== NEWSLETTERS
//  ======================
Route::get('newsletters', 'NewsletterControllerAPI@index'); // GET ALL NEWSLETTER
Route::get('newsletters/{id}', 'NewsletterControllersAPI@show'); // GET NEWSLETTER
Route::middleware('auth:api')->post('newsletters/create', 'NewsletterControllerAPI@store'); // CREATE NEWSLETTER
Route::middleware('auth:api')->delete('newsletters/{id}/delete', 'NewsletterControllerAPI@destroy'); // DELETE NEWSLETTER
Route::middleware('auth:api')->post('newsletters/{id}/update', 'NewsletterControllerAPI@update'); // EDIT NEWSLETTER
Route::post('newsletter/subscribe', 'NewsletterControllerAPI@subscribe'); // SUBSCRIBE NEWSLETTER
Route::delete('newsletter/{email}/unsubcribe', 'NewsletterControllerAPI@unsubscribe'); // DELETE SUBSCRIPTION OF NEWSLETTER
Route::post('newsletter/subscribed', 'NewsletterControllerAPI@subscribed'); // CHECK IF USER IS IN NEWSLETTER SUBSCRIPTION
Route::middleware('auth:api')->post('newsletters/{id}/publish', 'NewsletterControllerAPI@publish'); // PUBLISH NEWSLETTER

//  ==== QUESTIONS
//  ======================
Route::middleware('auth:api')->post('questions/create', 'UserQuestionControllerAPI@store'); // EDIT USER QUESTIONS
Route::middleware('auth:api')->get('questions', 'UserQuestionControllerAPI@index'); // GET ALL USER QUESTIONS
Route::middleware('auth:api')->get('questions/answered', 'UserQuestionControllerAPI@answered'); // GET ANSWERED USER QUESTIONS
Route::middleware('auth:api')->get('questions/notAnswered', 'UserQuestionControllerAPI@notAnswered'); // GET NOT ANSWERED USER QUESTIONS
Route::middleware('auth:api')->delete('questions/{id}/delete', 'UserQuestionControllerAPI@deleteQuestion'); // DELETE USER QUESTIONS
Route::middleware('auth:api')->post('questions/answer', 'UserQuestionControllerAPI@answer'); // ANSWER USER QUESTIONS

//  ==== FAQS
//  ======================
Route::get('faqs', 'FAQControllerAPI@index'); // GET FAQS
Route::get('faqs/{id}', 'FAQControllerAPI@show'); // GET FAQ BY ID
Route::middleware('auth:api')->post('faqs/create/clean', 'FAQControllerAPI@cleanStore'); // CREATE CLEAN FAQ
Route::middleware('auth:api')->post('faqs/create', 'FAQControllerAPI@store'); // CREATE FAQS FROM USER QUESTION
Route::middleware('auth:api')->delete('faqs/{id}/delete', 'FAQControllerAPI@destroy'); // DELETE FAQ
Route::middleware('auth:api')->post('faqs/{id}/update', 'FAQControllerAPI@update'); // EDIT FAQ

//  ==== RSS NEWS
//  ======================
Route::get('rssNews', 'RSSNewsControllerAPI@index'); // GET RSS NEWS
Route::middleware('auth:api')->post('rssNews/create', 'RSSNewsControllerAPI@store'); // ADD RSS NEWS
Route::middleware('auth:api')->delete('rssNews/{id}/delete', 'RSSNewsControllerAPI@destroy'); // DELETE RSS NEWS
Route::get('rssNews/{id}', 'RSSNewsControllerAPI@show'); // GET RSS NEWS BY ID
Route::middleware('auth:api')->post('rssNews/{id}/update', 'RSSNewsControllerAPI@update'); // EDIT RSS NEWS

//  ==== NEWS
//  ======================
Route::middleware('auth:api')->post('news/create', 'NewsControllerAPI@store'); // ADD RSS OF NEWS
Route::get('news', 'NewsControllerAPI@index');

/******************
	USER ROUTES
 *****************/
	
//  ==== USERS
//  ======================
Route::middleware('auth:api')->post('users', 'UserControllerAPI@getUsers'); //GET LIST OF USERS TO MANAGE
Route::middleware(['auth:api','isAdmin'])->post('usersForStatus', 'UserControllerAPI@getUsersForStatus'); //GET LIST OF USERS FOR STATUS TO MANAGE
Route::middleware('auth:api')->post('/user/update', 'UserControllerAPI@updateUserSettings'); //UPDATE USER INFO
Route::middleware('auth:api')->delete('deleteOwnAccount', 'UserControllerAPI@deleteOwnAccount'); //DELETE USER

/******************
 USER/ADMIN ROUTES
 *****************/

//  ==== USER
//  ======================
Route::middleware('auth:api')->post('/user/avatar/update', 'UserControllerAPI@updateAvatar'); //UPDATE AVATAR
Route::middleware('auth:api')->post('/user/password/update', 'UserControllerAPI@updatePassword'); //UPDATE PASSWORD

