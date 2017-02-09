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
    Route::get('/testmail',  [
     'as' => 'testmail2',
     'uses' => 'HomeController@index',
     
    ]);
    Route::get('/',  [
     'as' => 'dashboard',
     'uses' => 'DashboardController@index',
     
    ]);
    Route::get('/home',  [
     'as' => 'dashboard-home',
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

    #files(Gallery)
    Route::post('files', [
        'as'   => 'save_file',
        'uses' => 'FilesController@store'
    ]);
    Route::post('files/{file}', [
        'as'   => 'delete_file',
        'uses' => 'FilesController@destroy'
    ]);

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
    Route::post('clients/export', [
        'as' => 'export_clients',
        'uses' => 'ClientsController@export'
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
    Route::post('clients/comments', [
        'as'   => 'save_comments_clients',
        'uses' => 'ClientsController@comments'
    ]);
     Route::put('clients/comments/update', [
        'as'   => 'update_comments_clients',
        'uses' => 'ClientsController@updateComments'
    ]);
    Route::post('clients/comments/delete', [
        'as'   => 'delete_comments_clients',
        'uses' => 'ClientsController@deleteComments'
    ]);


    Route::get('tasks/list', [
        'as' => 'tasks_list',
        'uses' => 'TasksController@list_tasks'
    ]);
     Route::get('tasks/notification', [
        'as' => 'tasks_notification',
        'uses' => 'TasksController@notification'
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
    Route::get('project/properties/list', [
        'as' => 'project_properties_list',
        'uses' => 'PropertiesController@propertiesByProject'
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

    Route::resource('projects', 'ProjectsController');

    Route::get('projects', [
        'as'   => 'projects',
        'uses' => 'ProjectsController@index'

    ]);
    Route::post('projects/multiple', [
        'as'   => 'projects_option_multiple',
        'uses' => 'ProjectsController@option_multiple'
    ]);

    Route::get('projects/{project}/properties/create', [
        'as' => 'create_property_to_project',
        'uses' => 'ProjectsController@create_property'
    ]);

    Route::resource('banks', 'BanksController');

    Route::get('banks', [
        'as'   => 'banks',
        'uses' => 'BanksController@index'

    ]);
    Route::post('banks/multiple', [
        'as'   => 'banks_option_multiple',
        'uses' => 'BanksController@option_multiple'
    ]);

    Route::get('banks/{bank}/requirement/create', [
        'as' => 'create_requirement_to_bank',
        'uses' => 'BanksController@create_requirement'
    ]);

     Route::get('bank/requirements/list', [
        'as' => 'bank_requirements_list',
        'uses' => 'RequirementsController@requirementsByBank'
    ]);

    Route::resource('requirements', 'RequirementsController');

    Route::get('requirements', [
        'as'   => 'requirements',
        'uses' => 'RequirementsController@index'

    ]);
    Route::post('requirements/multiple', [
        'as'   => 'requirements_option_multiple',
        'uses' => 'RequirementsController@option_multiple'
    ]);

     Route::get('reports/tracing', [
        'as' => 'r_tracing',
        'uses' => 'ReportsController@tracing'
    ]);
     Route::get('reports/sales', [
        'as' => 'r_sales',
        'uses' => 'ReportsController@sales'
    ]);
     Route::post('reports/sales/export', [
        'as' => 'export_sales',
        'uses' => 'ReportsController@exportSales'
    ]);
      Route::post('reports/tracing/export', [
        'as' => 'export_tracing',
        'uses' => 'ReportsController@exportTracing'
    ]);

   

});
