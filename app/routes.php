<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses'=>'HomeController@hello', 'as' => 'home'));

Route::group(array('prefix' => '/survey'), function()
{	//this get('/' is prettye much the '/survey'
	Route::get('/', array('uses' => 'SurveyController@index', 'as'=> 'survey-home'));
	Route::get('/category/{id}', array('uses' => 'SurveyController@category', 'as' => 'survey-category'));
	Route::get('/delete-category/{id}', array('uses' => 'SurveyController@deleteCategory', 'as' => 'survey-delete-category'));
	Route::group(array('before' => 'auth'), function()
	{
			Route::group(array('before' => 'csrf'), function()
			{
				Route::get('/category/{id}/edit', array('uses' => 'QuestionController@getEdit', 'as' => 'survey-edit'));
				Route::post('/category/{id}/edit', array('uses' => 'QuestionController@storeQuestions', 'as' => 'survey-store-questions'));
				Route::post('/group', array('uses' => 'SurveyController@storeGroup', 'as' => 'survey-store-group'));
				Route::post('/', array('uses' => 'SurveyController@storeCategory', 'as' => 'survey-store-category'));
				Route::get('/delete-group', array('uses' => 'SurveyController@deleteGroup', 'as' => 'survey-delete-group'));
				Route::post('/category/{id}', array('uses' => 'QuestionController@storeAnswers', 'as' => 'survey-submit'));
			});
	});

});

Route::group(array('before' => 'guest'), function()
{	//These two routes are only accessible if you are in guest system
	Route::get('/user/create', array('uses'=>'UserController@getCreate', 'as' => 'getCreate'));
	Route::get('/user/login', array('uses'=>'UserController@getLogin', 'as' => 'getLogin'));

	Route::group(array('before' => 'csrf'), function() //cross site request...
	{	//handles database connection
		//This is a named route
		Route::post('/user/create', array('uses'=>'UserController@postCreate', 'as' => 'postCreate'));
		Route::post('/user/login', array('uses'=>'UserController@postLogin', 'as' => 'postLogin'));
	});

});

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});
/*
Route::group(array('before'=> 'admin'), function()
{
	Route::get('/group/{id}/delete', array('uses' => '', 'as' => ''));
});
*/
