<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {
    Route::auth();

    //Route::get('/home', 'HomeController@index');

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
    Route::get('clients/{client}/tasks/create', [
        'as' => 'create_task_to_client',
        'uses' => 'ClientsController@create_task'
    ]);
    Route::post('clients/import', [
        'as' => 'import_clients',
        'uses' => 'ClientsController@import'
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


    Route::get('task/list', [
        'as' => 'tasks_list',
        'uses' => 'TasksController@list_tasks'
    ]);
    Route::resource('tasks', 'TasksController');

    Route::get('tasks', [
        'as'   => 'tasks',
        'uses' => 'TasksController@index'

    ]);
    Route::post('tasks/multiple', [
        'as'   => 'tasks_option_multiple',
        'uses' => 'TasksController@option_multiple'
    ]);
    foreach (['pend', 'comp'] as $key)
    {
        Route::post('tasks/{task}/' . $key, array(
            'as'   => 'tasks.' . $key,
            'uses' => 'TasksController@' . $key,
        ));
    }

    Route::get('properties/list', [
        'as' => 'properties_list',
        'uses' => 'PropertiesController@list_properties'
    ]);
    
    Route::resource('properties', 'PropertiesController');

    Route::get('properties', [
        'as'   => 'properties',
        'uses' => 'PropertiesController@index'

    ]);
    Route::post('properties/multiple', [
        'as'   => 'properties_option_multiple',
        'uses' => 'PropertiesController@option_multiple'
    ]);
     foreach (['pend', 'free', 'sold'] as $key)
    {
        Route::post('properties/{property}/' . $key, array(
            'as'   => 'properties.' . $key,
            'uses' => 'PropertiesController@' . $key,
        ));
    }
});
