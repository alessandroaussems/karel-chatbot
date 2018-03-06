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

Route::get('/', function () {
    return view('chat');
});
Route::get('chat/{message}','ChatController@handleMessage');

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('admin', 'AdminController@index');

Route::resource('messages', 'MessageController');
Route::get('messages/{id}/delete','MessageController@destroy');

Route::resource('sentences', 'SentenceController');
Route::get('sentences/{id}/delete','SentenceController@destroy');
Route::get('sentences/create/{messageid}','SentenceController@create');
Route::get('sentences/edit/{id}/message/{messageid}','SentenceController@edit');