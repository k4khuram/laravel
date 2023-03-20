<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('/breed/savebyapi','BreedController@cloneAllBreedsFromDogAPI');
Route::get('/breed/random','BreedController@getRandomBreed');
Route::get('/breed/{id}/image','BreedController@getImageByBreedId');
Route::resource('breed','BreedController');

Route::resource('park', 'ParkController');

Route::post('/user/{user_id}/park','UserController@associatePark');
Route::post('/user/{user_id}/breed','UserController@associateBreed');
Route::post('/park/{park_id}/breed','ParkController@associateBreed');




