<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','WelcomeController@welcome');
Route::get('session/','WelcomeController@loadsession');
Route::resource('notifications', 'NotificationController');
Route::get('chat/{message}','ChatController@handleMessage');
Route::get('livechat/{sessionid}','LivechatController@livechat');
Route::get('sendliveresponse/{message}/sessionid/{sessionid}','LivechatController@handleMessage');

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('admin', 'AdminController@index');
Route::get('tags', 'AdminController@tags');
Route::get('livechats', 'AdminController@chats');

Route::resource('messages', 'MessageController');
Route::get('messages/{id}/delete','MessageController@destroy');

Route::resource('sentences', 'SentenceController');
Route::get('sentences/{id}/delete/message/{messageid}','SentenceController@destroy');
Route::get('sentences/create/{messageid}','SentenceController@create');
Route::get('sentences/edit/{id}/message/{messageid}','SentenceController@edit');

Route::resource('users', 'UserController');
Route::get('users/{id}/delete','UserController@destroy');

Route::put("kdglogin",'KdgLoginController@login');

Route::get("pulse",'HeartBleedController@handlePulse');
Route::get("adminpulse",'HeartBleedController@handleAdminPulse');

Route::get("/about", function(){
    return view("about")->with("pagetitle", "Promo");
});