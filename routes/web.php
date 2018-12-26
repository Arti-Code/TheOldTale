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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/character/index', 'CharacterController@index')->name('character.index');
Route::get('/character/myself', 'CharacterController@myself')->name('character.myself');
Route::get('/character/create', 'CharacterController@create')->name('character.create');
Route::post('/character/store', 'CharacterController@store')->name('character.store');
Route::get('/character/destroy/{id}', 'CharacterController@destroy')->name('character.destroy');
Route::get('/character/select/{id}', 'CharacterController@select')->name('character.select');

Route::get('/location/edit/{id}', 'NameController@edit')->name('name.edit');
Route::post('/location/store', 'NameController@store')->name('name.store');

Route::get('/admin/universum/index', 'UniversumController@index')->name('admin.universum.index');
Route::get('/admin/universum/nextturn/{id}', 'UniversumController@nextturn')->name('admin.universum.nextturn');

Route::get('/location/show', 'LocationController@show')->name('location.show');

Route::get('/navigation/index', 'RouteController@index')->name('navigation.index');
Route::get('/navigation/select/{id}', 'RouteController@select')->name('navigation.select');
Route::get('/navigation/travel', 'RouteController@travel')->name('navigation.travel');
Route::get('/navigation/back', 'RouteController@back')->name('navigation.back');
