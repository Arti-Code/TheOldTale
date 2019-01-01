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
Route::get('/character/myself', 'CharacterController@myself')->name('character.myself')->middleware('auth');
Route::get('/character/create', 'CharacterController@create')->name('character.create')->middleware('auth');
Route::post('/character/store', 'CharacterController@store')->name('character.store')->middleware('auth');
Route::get('/character/destroy/{id}', 'CharacterController@destroy')->name('character.destroy')->middleware('auth');
Route::get('/character/select/{id}', 'CharacterController@select')->name('character.select')->middleware('auth');

Route::get('/location/edit/{id}', 'NameController@edit')->name('name.edit')->middleware('auth');
Route::post('/location/store', 'NameController@store')->name('name.store')->middleware('auth');

Route::get('/admin/universum/index', 'UniversumController@index')->name('admin.universum.index')->middleware('auth');
Route::get('/admin/universum/nextturn/{id}', 'UniversumController@nextturn')->name('admin.universum.nextturn')->middleware('auth');

Route::get('/location/show', 'LocationController@show')->name('location.show')->middleware('auth');

Route::get('/navigation/index', 'RouteController@index')->name('navigation.index')->middleware('auth');
Route::get('/navigation/select/{id}', 'RouteController@select')->name('navigation.select')->middleware('auth');
Route::get('/navigation/travel', 'RouteController@travel')->name('navigation.travel')->middleware('auth');
Route::get('/navigation/back', 'RouteController@back')->name('navigation.back')->middleware('auth');

Route::get('/message/index', 'MessageController@index')->name('message.index')->middleware('auth');
Route::post('/message/store', 'MessageController@store')->name('message.store')->middleware('auth');

Route::get('/options/index', 'HomeController@options')->name('options.index')->middleware('auth');

Route::get('/resource/select/{id}', 'ResourceController@select')->name('resource.select')->middleware('auth');

Route::get('/progress/destroy/{id}', 'ProgressController@destroy')->name('progress.destroy')->middleware('auth');

Route::get('/item/index', 'ItemController@index')->name('item.index')->middleware('auth');
Route::get('/item/show/{id}', 'ItemController@show')->name('item.show')->middleware('auth');
Route::post('/item/dropoff', 'ItemController@dropoff')->name('item.dropoff')->middleware('auth');
