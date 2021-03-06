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

Route::get('/','WelcomeController@welcome')->name('home');
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

Route::resource('keywords', 'KeywordController');
Route::get('keywords/{id}/delete/message/{messageid}','KeywordController@destroy');
Route::get('keywords/create/{messageid}','KeywordController@create');
Route::get('keywords/edit/{id}/message/{messageid}','KeywordController@edit');

Route::resource('users', 'UserController');
Route::get('users/{id}/delete','UserController@destroy');

Route::put("kdglogin",'KdgLoginController@login');

Route::get("pulse",'HeartBleedController@handlePulse');
Route::get("adminpulse",'HeartBleedController@handleAdminPulse');

Route::get("/promo", function(){
    return view("promo")->with("pagetitle", "Promo");
})->name('promo');

Route::get("/about", function(){
    return view("about")->with("pagetitle", "Over");
})->name('about');