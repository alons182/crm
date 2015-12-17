<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'auth'], function ()
{

    Route::get('/',  [
     'as' => 'dashboard',
     'uses' => 'DashboardController@index',
     
    ]);

   Route::get('sellers/list', [
        'as' => 'sellers_list',
        'uses' => 'SellersController@list_sellers'
    ]);

    Route::resource('sellers', 'SellersController');
    
    Route::get('sellers', [
        'as'   => 'sellers',
        'uses' => 'SellersController@index'

    ]);
    foreach (['active', 'inactive'] as $key)
    {
        Route::post('sellers/{seller}/' . $key, array(
            'as'   => 'sellers.' . $key,
            'uses' => 'SellersController@' . $key,
        ));
    }

     
    Route::get('clients/list', [
        'as' => 'clients_list',
        'uses' => 'ClientsController@list_clients'
    ]);
    Route::resource('clients', 'ClientsController');

    Route::get('clients', [
        'as'   => 'clients',
        'uses' => 'ClientsController@index'

    ]);
    Route::post('clients/multiple', [
        'as'   => 'option_multiple',
        'uses' => 'ClientsController@option_multiple'
    ]);

});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
