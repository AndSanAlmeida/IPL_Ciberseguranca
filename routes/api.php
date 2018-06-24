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


Route::group(['middleware' => 'prevent-back-history'],function(){
	Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
	Route::get('/', function() {
		return view('vue.index');
	});
});

// GENERAL USER
// -------------------- AUTH --------------------
Route::post('register', 'UserControllerAPI@store');
Route::post('login', 'LoginControllerAPI@login');
Route::post('password/email', 'LoginControllerAPI@sendResetLinkEmail');
Route::post('password/reset', 'LoginControllerAPI@resetPassword');

// -------------------- EVENTS --------------------
Route::get('events', 'EventControllerAPI@index'); //GET LIST OF EVENTS
Route::get('events/{id}', 'EventControllerAPI@show'); // GET EVENT BY ID
Route::get('events/{id}/users', 'EventControllerAPI@getUsersSubscribed'); // GET SUBSCRIBED USERS OF A EVENT

// -------------------- GLOSSARY --------------------
Route::get('glossary/byLetter/{letter}', 'GlossaryControllerAPI@getGlossaryItensByLetter'); // GET GLOSSARY BY LETTER
Route::get('glossary/letters', 'GlossaryControllerAPI@getLetterInGlossary'); // GET ALL LETTERS IN GLOSSARY
Route::get('glossary', 'GlossaryControllerAPI@index'); // GET GLOSSARY
Route::get('glossary/{id}', 'GlossaryControllerAPI@show'); // GET ITEM FROM GLOSSARY BY ID

// -------------------- SETTINGS --------------------
Route::get('settings/ourMission', 'ConfigControllerAPI@getOurMission'); // GET OUR MISSION
Route::get('settings/aboutUs', 'ConfigControllerAPI@getAboutUs'); // GET ABOUT US
Route::get('settings/activities', 'ConfigControllerAPI@getActivities'); // GET ACTIVITIES
Route::get('settings/resources', 'ConfigControllerAPI@getResources'); // GET RESOURCES

// -------------------- USEFUL LINKS --------------------
Route::get('usefulLinks', 'UsefulLinksControllerAPI@index'); // GET USERFULL LINKS
Route::get('usefulLinks/{id}', 'UsefulLinksControllerAPI@show'); // GET ITEM OF USEFULL LINK BY ID

// -------------------- DOCUMENTS --------------------
Route::get('documents', 'DocumentsControllerAPI@index'); // GET DOCUMENTS
Route::get('documents/{id}', 'DocumentsControllerAPI@show'); //GET ITEM OF DOCUMENT BY ID

// -------------------- NEWSLETTERS --------------------
Route::get('newsletters/{id}', 'NewsletterControllerAPI@show'); // GET NEWSLETTER
Route::post('newsletter/subscribe', 'NewsletterControllerAPI@subscribe'); // SUBSCRIBE NEWSLETTER
Route::delete('newsletter/unsubcribe/{email}', 'NewsletterControllerAPI@unsubscribe'); // DELETE SUBSCRIPTION OF NEWSLETTER
Route::post('newsletter/subscribed', 'NewsletterControllerAPI@subscribed'); // CHECK IF USER IS IN NEWSLETTER SUBSCRIPTION
Route::get('newsletter/getPublishedNewsletters', 'NewsletterControllerAPI@getPublishedNewsletters'); // CHECK IF USER IS IN NEWSLETTER SUBSCRIPTION

// -------------------- FAQS --------------------
Route::get('faqs', 'FAQControllerAPI@index'); // GET FAQS
Route::get('faqs/{id}', 'FAQControllerAPI@show'); // GET FAQ BY ID

// -------------------- NEWS RSS --------------------
Route::get('rssNews', 'RSSNewsControllerAPI@index'); // GET RSS NEWS
Route::get('rssNews/{id}', 'RSSNewsControllerAPI@show'); // GET RSS NEWS BY ID

// -------------------- ALERTS RSS --------------------
Route::get('rssAlerts', 'RSSAlertsControllerAPI@index'); // GET RSS ALERTS
Route::get('rssAlerts/{id}', 'RSSAlertsControllerAPI@show'); // GET RSS ALERTS BY ID


// -------------------- NEWS --------------------
Route::get('news', 'NewsControllerAPI@index');

// -------------------- ALERTS --------------------
Route::get('alerts', 'AlertsControllerAPI@index');

// LOGGED USER
Route::middleware('auth:api')->group(function () {
	// -------------------- USERS --------------------
	Route::post('/user/avatar/update', 'UserControllerAPI@updateAvatar'); //UPDATE AVATAR
	Route::post('/user/password/update', 'UserControllerAPI@updatePassword'); //UPDATE PASSWORD
	Route::post('/user/update', 'UserControllerAPI@updateUserSettings'); //UPDATE USER INFO
	Route::delete('deleteOwnAccount', 'UserControllerAPI@deleteOwnAccount'); //DELETE USER
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});

	// -------------------- EVENTS --------------------
	Route::post('events/subscribe', 'EventControllerAPI@subscribe'); // SUBSCRIBE TO EVENT
	Route::post('events/unsubscribe', 'EventControllerAPI@unsubscribe'); // UNSUBSCRIBE TO EVENT
	Route::post('events/isSubscribed', 'EventControllerAPI@isSubscribed'); // GET LIST OF EVENTS ID OF SUBSCRIBED EVENTS BY USER

	// -------------------- QUESTIONS --------------------
	Route::post('questions/create', 'UserQuestionControllerAPI@store'); // CREATE QUESTION

	// ADMIN USER
	Route::middleware('isAdmin')->group(function () {
		// -------------------- USER --------------------
		Route::post('users', 'UserControllerAPI@getUsers'); //GET LIST OF USERS TO MANAGE
		Route::put('users/{id}', 'UserControllerAPI@updateState'); //CHANGE STATE USER
		Route::delete('users/{id}', 'UserControllerAPI@delete'); //DELETE USER
		Route::get('user/{id}', 'UserControllerAPI@getUserById'); // GET USER BY ID
		Route::post('usersForStatus', 'UserControllerAPI@getUsersForStatus'); //GET LIST OF USERS FOR STATUS TO MANAGE
		Route::post('users/{id}/promote', 'UserControllerAPI@promoteUser'); // TURN THE USER INTO A ADMIN
		
		// -------------------- EVENTS --------------------
		Route::post('events/create', 'EventControllerAPI@create'); // CREATE EVENT
		Route::delete('event/{id}/delete', 'EventControllerAPI@destroy'); // DELETE EVENT
		Route::post('events/{id}/update', 'EventControllerAPI@edit'); // EDIT EVENT

		// -------------------- GLOSSARY --------------------
		Route::post('glossary/create', 'GlossaryControllerAPI@store'); // CREATE ITEM OF GLOSSARY
		Route::delete('glossary/{id}/delete', 'GlossaryControllerAPI@destroy'); // DELETE ITEM OF GLOSSARY
		Route::post('glossary/{id}/update', 'GlossaryControllerAPI@update'); // EDIT ITEM OF GLOSSARY

		// -------------------- SETTINGS --------------------
		Route::get('settings', 'ConfigControllerAPI@getPlatformData'); // GET PLATFORM EMAIL
		Route::post('settings/update', 'ConfigControllerAPI@update'); // UPDATE PLATFORM EMAIL
		Route::post('settings/ourMission/update', 'ConfigControllerAPI@ourMissionUpdate'); // UPDATE OUR MISSION
		Route::post('settings/aboutUs/update', 'ConfigControllerAPI@aboutUsUpdate'); // UPDATE ABOUT US
		Route::post('settings/activities/update', 'ConfigControllerAPI@ActivitiesUpdate'); // UPDATE ACTIVITIES
		Route::post('settings/resources/update', 'ConfigControllerAPI@ResourcesUpdate'); // UPDATE RESOURCES
		Route::post('settings/home/image', 'ConfigControllerAPI@HomeImageUpdate'); // UPDATE HOME IMAGE
		Route::post('settings/mission/image', 'ConfigControllerAPI@MissionImageUpdate'); // UPDATE HOME IMAGE

		// -------------------- USEFUL LINKS --------------------
		Route::post('usefulLinks/create', 'UsefulLinksControllerAPI@store'); // CREATE ITEM OF USEFULL LINK
		Route::delete('usefulLinks/{id}/delete', 'UsefulLinksControllerAPI@destroy'); // DELETE ITEM OF USEFULL LINK
		Route::post('usefulLinks/{id}/update', 'UsefulLinksControllerAPI@update'); // EDIT ITEM OF USEFULL LINK

		// -------------------- DOCUMENTS --------------------
		Route::post('documents/create', 'DocumentsControllerAPI@store'); // CREATE ITEM OF DOCUMENTS
		Route::delete('documents/{id}/delete', 'DocumentsControllerAPI@destroy'); // DELETE ITEM OF DOCUMENTS
		Route::post('documents/{id}/update', 'DocumentsControllerAPI@update'); // EDIT ITEM OF DOCUMENTS

		// -------------------- NEWSLETTER --------------------
		Route::post('newsletters/create', 'NewsletterControllerAPI@store'); // CREATE NEWSLETTER
		Route::delete('newsletters/{id}/delete', 'NewsletterControllerAPI@destroy'); // DELETE NEWSLETTER
		Route::post('newsletters/{id}/update', 'NewsletterControllerAPI@update'); // EDIT NEWSLETTER
		Route::post('newsletters/{id}/publish', 'NewsletterControllerAPI@publish'); // PUBLISH NEWSLETTER
		Route::get('newsletters', 'NewsletterControllerAPI@index'); // GET ALL NEWSLETTER
		Route::post('newsletters/getSubscribers', 'NewsletterControllerAPI@getSubscribers'); // GET NUMBER OF SUBSCRIBED
		

		// -------------------- USER QUESTIONS --------------------
		Route::get('questions', 'UserQuestionControllerAPI@index'); // GET ALL USER QUESTIONS
		Route::get('questions/answered', 'UserQuestionControllerAPI@answered'); // GET ANSWERED USER QUESTIONS
		Route::get('questions/notAnswered', 'UserQuestionControllerAPI@notAnswered'); // GET NOT ANSWERED USER QUESTIONS
		Route::delete('questions/{id}/delete', 'UserQuestionControllerAPI@deleteQuestion'); // DELETE USER QUESTIONS
		Route::post('questions/answer', 'UserQuestionControllerAPI@answer'); // ANSWER USER QUESTIONS

		// -------------------- FAQS --------------------
		Route::post('faqs/create/clean', 'FAQControllerAPI@cleanStore'); // CREATE CLEAN FAQ
		Route::post('faqs/create', 'FAQControllerAPI@store'); // CREATE FAQS FROM USER QUESTION
		Route::delete('faqs/{id}/delete', 'FAQControllerAPI@destroy'); // DELETE FAQ
		Route::post('faqs/{id}/update', 'FAQControllerAPI@update'); // EDIT FAQ

		// -------------------- RSS NEWS --------------------
		Route::post('rssNews/create', 'RSSNewsControllerAPI@store'); // ADD RSS NEWS
		Route::delete('rssNews/{id}/delete', 'RSSNewsControllerAPI@destroy'); // DELETE RSS NEWS
		Route::post('rssNews/{id}/update', 'RSSNewsControllerAPI@update'); // EDIT RSS NEWS

		// -------------------- NEWS --------------------
		Route::post('news/create', 'NewsControllerAPI@store'); // ADD RSS OF NEWS
		Route::post('news/rss', 'NewsControllerAPI@createXML'); // EDIT RSS NEWS
		Route::delete('news/{id}/delete', 'NewsControllerAPI@destroy'); // DELETE NEWS
		Route::get('news/{id}', 'NewsControllerAPI@show'); // GET NEWS BY ID
		Route::post('news/{id}/update', 'NewsControllerAPI@update'); // EDIT NEWS

		// -------------------- RSS ALERTS --------------------
		Route::post('rssAlerts/create', 'RSSAlertsControllerAPI@store'); // ADD RSS ALERTS
		Route::delete('rssAlerts/{id}/delete', 'RSSAlertsControllerAPI@destroy'); // DELETE RSS ALERTS
		Route::post('rssAlerts/{id}/update', 'RSSAlertsControllerAPI@update'); // EDIT RSS ALERTS

		// -------------------- ALERTS --------------------
		Route::post('alerts/create', 'AlertsControllerAPI@store'); // ADD RSS OF ALERTS
		Route::post('alerts/{id}/update', 'AlertsControllerAPI@update'); // EDIT ALERTS
		Route::delete('alerts/{id}/delete', 'AlertsControllerAPI@destroy'); // DELETE ALERTS
		Route::get('alerts/{id}', 'AlertsControllerAPI@show'); // GET ALERTS BY ID
		Route::post('alerts/rss', 'AlertsControllerAPI@createXML'); // EDIT RSS NEWS
	});	
});

