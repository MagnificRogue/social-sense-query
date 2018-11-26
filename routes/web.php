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
    return view('welcome');
});


Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('about', 'PagesController@about')->name('about');
Route::get('/', 'PagesController@landing')->name('landing');

Route::get('/meta-queries/create', 'MetaQueryController@create');
Route::post('meta-queries', 'MetaQueryController@store');
Route::get('/meta-queries/{id}', 'MetaQueryController@show');
Route::get('/meta-queries/{id}/edit', 'MetaQueryController@edit');

Route::get('/meta-queries/{id}/submit', 'MetaQueryController@submit');

Route::get('login/{provider}', 'AuthorizationController@authorizeProvider')->name('authorizeProvider');
Route::get('login/{prodier}/return', 'AuthorizationController@createAuthorization')->name('authorizationReturn');

Route::resource('queries', 'QueryController');
Route::resource('users', 'UserController');
Route::resource('servers', 'GraphQLServerController')->except(['show']);
Route::get('servers/{server}/refresh', 'GraphQLServerController@refresh')->name('servers.refresh');
Route::get('queries/{id}/submit', 'QueryController@submit');
Route::resource('applications','ApplicationsController')->except(['show','index', 'edit']);;

Route::get('/contact/me', 'InterestedPartyController@create');
Route::get('/contact', 'InterestedPartyController@index')->middleware('admin');
Route::post('/contact', 'InterestedPartyController@store');

use Illuminate\Http\Request;
Route::post('/callback/handshake', function(Request $request) {
	return response('CREATED', 201)->header('Content-Type','text/plain');
});
Route::post('/callback', function(Request $request) {
	return response('CREATED', 201)->header('Content-Type','text/plain');
});
