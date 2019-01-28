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

{   // Character
    Route::get('/character/index', 'CharacterController@index')->name('character.index')->middleware('auth');
    Route::get('/character/myself', 'CharacterController@myself')->name('character.myself')->middleware('auth', 'char');
    Route::get('/character/create', 'CharacterController@create')->name('character.create')->middleware('auth');
    Route::post('/character/store', 'CharacterController@store')->name('character.store')->middleware('auth');
    Route::get('/character/destroy/{id}', 'CharacterController@destroy')->name('character.destroy')->middleware('auth');
    Route::get('/character/eat/{id}', 'CharacterController@eat')->name('character.eat')->middleware('auth', 'char');
    Route::get('/character/select/{id}', 'CharacterController@select')->name('character.select')->middleware('auth');
    Route::get('/character/craft', 'CharacterController@craft')->name('character.craft')->middleware('auth', 'char');
    Route::get('/progress/craft/{name}', 'ProgressController@craft')->name('progress.craft')->middleware('auth', 'char');
    Route::get('/character/fight', 'CharacterController@fight')->name('character.fight')->middleware('auth', 'char');
    Route::get('/character/weapon/equip/{id}', 'CharacterController@weaponEquip')->name('character.weapon.equip')->middleware('auth', 'char');
    Route::get('/character/other/{id}', 'CharacterController@other')->name('character.other')->middleware('auth', 'char');
    Route::get('/character/attack/{id}', 'CharacterController@attack')->name('character.attack')->middleware('auth', 'char');
    Route::get('/character/remove/{id}', 'CharacterController@remove')->name('character.remove')->middleware('auth');
}

{   //Location
    Route::get('/location/edit/{id}', 'NameController@edit')->name('name.edit')->middleware('auth', 'char');
    Route::post('/location/store', 'NameController@store')->name('name.store')->middleware('auth', 'char');
    Route::get('/location/show', 'LocationController@show')->name('location.show')->middleware('auth', 'char');
    Route::get('/location/place', 'LocationController@place')->name('location.place')->middleware('auth', 'char');

    Route::get('/util/location/list/{id}', 'UtilController@list')->name('util.location.list')->middleware('auth', 'char');
}

{   //Admin
    Route::get('/admin/universum/index', 'UniversumController@index')->name('admin.universum.index')->middleware('auth', 'admin');
    Route::get('/admin/universum/nextturn/{id}', 'UniversumController@nextturn')->name('admin.universum.nextturn')->middleware('auth', 'admin');
    Route::get('/admin/universum/destroy/{id}', 'UniversumController@destroy')->name('admin.universum.destroy')->middleware('auth', 'admin');
}

{   //Navigation
    Route::get('/navigation/index', 'RouteController@index')->name('navigation.index')->middleware('auth', 'char');
    Route::get('/navigation/select/{id}', 'RouteController@select')->name('navigation.select')->middleware('auth', 'char');
    Route::get('/navigation/travel', 'RouteController@travel')->name('navigation.travel')->middleware('auth', 'char');
    Route::get('/navigation/back', 'RouteController@back')->name('navigation.back')->middleware('auth', 'char');
}

{   //Message
    Route::get('/message/index', 'MessageController@index')->name('message.index')->middleware('auth', 'char');
    Route::post('/message/store', 'MessageController@store')->name('message.store')->middleware('auth', 'char');
    Route::post('/message/priv/store', 'MessageController@priv_store')->name('message.priv.store')->middleware('auth', 'char');
}

{   //Progress
    Route::get('/progress/destroy/{id}', 'ProgressController@destroy')->name('progress.destroy')->middleware('auth', 'char');
    Route::get('/progress/create/{mode}/{id}', 'ProgressController@create')->name('progress.create')->middleware('auth', 'char');
    Route::post('/progress/store', 'ProgressController@store')->name('progress.store')->middleware('auth', 'char');
    Route::get('/progress/construct/{type}', 'ProgressController@construct')->name('progress.construct')->middleware('auth', 'char');
}

{   //Item
    Route::get('/item/index', 'ItemController@index')->name('item.index')->middleware('auth', 'char');
    Route::get('/item/show/{id}', 'ItemController@show')->name('item.show')->middleware('auth', 'char');
    Route::post('/item/update', 'ItemController@update')->name('item.update')->middleware('auth', 'char');
    Route::get('/item/location', 'ItemController@location')->name('item.location')->middleware('auth', 'char');
}

Route::get('/options/index', 'HomeController@options')->name('options.index')->middleware('auth');

Route::post('/resource/store', 'ResourceController@store')->name('resource.store')->middleware('auth', 'char');