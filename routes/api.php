<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| To list all routes call "php artisan route:list".
| 
| ----------- Actions Handled By Resource Controller ------------
| +-----------+----------------------+---------+----------------+
| |   Verb    |         URI          | Action  |   Route Name   |
| +-----------+----------------------+---------+----------------+
| | GET       | /photos              | index   | photos.index   |
| | POST      | /photos              | store   | photos.store   |
| | GET       | /photos/{photo}      | show    | photos.show    |
| | PUT/PATCH | /photos/{photo}      | update  | photos.update  |
| | DELETE    | /photos/{photo}      | destroy | photos.destroy |
| +-----------+----------------------+---------+----------------+
|
| This can be archived with "Route::apiResource('photo', 'PhotoController');"
|
| --- NOTE ---
| Routes with parameters must be placed last or restricted with a regex. Otherwise they will impair the other routes.
|
*/

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/register/uniqueuser', 'AuthController@uniqueuser');
Route::get('/settings', 'SettingsController@index');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', 'AuthController@logout');

    Route::apiResource('trips', 'TripController');
    Route::apiResource('trips.locations', 'LocationController');
});
