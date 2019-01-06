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

Route::get('/welcome', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/character/index', 'CharacterController@index')->name('character.index')->middleware('auth');
Route::get('/character/myself', 'CharacterController@myself')->name('character.myself')->middleware('auth', 'char');
Route::get('/character/create', 'CharacterController@create')->name('character.create')->middleware('auth');
Route::post('/character/store', 'CharacterController@store')->name('character.store')->middleware('auth');
Route::get('/character/destroy/{id}', 'CharacterController@destroy')->name('character.destroy')->middleware('auth');
Route::get('/character/eat/{id}', 'CharacterController@eat')->name('character.eat')->middleware('auth', 'char');
Route::get('/character/select/{id}', 'CharacterController@select')->name('character.select')->middleware('auth');
Route::get('/character/craft', 'CharacterController@craft')->name('character.craft')->middleware('auth', 'char');
Route::get('/progress/craft/{name}', 'ProgressController@craft')->name('progress.craft')->middleware('auth', 'char');

Route::get('/location/edit/{id}', 'NameController@edit')->name('name.edit')->middleware('auth', 'char');
Route::post('/location/store', 'NameController@store')->name('name.store')->middleware('auth', 'char');

Route::get('/admin/universum/index', 'UniversumController@index')->name('admin.universum.index')->middleware('auth', 'admin');
Route::get('/admin/universum/nextturn/{id}', 'UniversumController@nextturn')->name('admin.universum.nextturn')->middleware('auth', 'admin');

Route::get('/location/show', 'LocationController@show')->name('location.show')->middleware('auth', 'char');

Route::get('/navigation/index', 'RouteController@index')->name('navigation.index')->middleware('auth', 'char');
Route::get('/navigation/select/{id}', 'RouteController@select')->name('navigation.select')->middleware('auth', 'char');
Route::get('/navigation/travel', 'RouteController@travel')->name('navigation.travel')->middleware('auth', 'char');
Route::get('/navigation/back', 'RouteController@back')->name('navigation.back')->middleware('auth', 'char');

Route::get('/message/index', 'MessageController@index')->name('message.index')->middleware('auth', 'char');
Route::post('/message/store', 'MessageController@store')->name('message.store')->middleware('auth', 'char');

Route::get('/options/index', 'HomeController@options')->name('options.index')->middleware('auth');

Route::get('/resource/select/{id}', 'ResourceController@select')->name('resource.select')->middleware('auth', 'char');

Route::get('/progress/destroy/{id}', 'ProgressController@destroy')->name('progress.destroy')->middleware('auth', 'char');

Route::get('/item/index', 'ItemController@index')->name('item.index')->middleware('auth', 'char');
Route::get('/item/show/{id}', 'ItemController@show')->name('item.show')->middleware('auth', 'char');
Route::post('/item/update', 'ItemController@update')->name('item.update')->middleware('auth', 'char');
Route::get('/item/location', 'ItemController@location')->name('item.location')->middleware('auth', 'char');
