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
Route::post('/notifications', 'NotificationController@notifications');
Route::post('/notifications-view', 'NotificationController@viewer');

Route::get('/', 'HomeController@index');
Route::group(['middleware' => 'auth'], function () {
	Route::group(['namespace' => 'Admin'], function () {
		Route::resource('usuarios', 'UsersController');
		Route::get('perfil/{id?}', 'UsersController@profile')->name('profile');
		Route::get('get-data-user', 'UsersController@dataForRegister');
		Route::get('get-data-states/{state}', 'UsersController@dataStates');
		Route::post('save-image/{id?}', 'UsersController@saveImage');
		Route::post('change-password', 'UsersController@changePassword');
	});
	Route::group(['namespace' => 'ShippingManager'], function () {
		Route::resource('consolidados', 'ConsolidatedController');
		Route::post('data-for-consolidated', 'ConsolidatedController@dataForRegister');
		Route::post('extend-consolidated/{consolidated}', 'ConsolidatedController@extend');
		Route::post('formalize-consolidated/{consolidated}', 'ConsolidatedController@formalize');
		Route::resource('tracking', 'TrackingController');
	});

    //    Route::get('/link1', function ()    {
	//        // Uses Auth Middleware
	//    });
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

Auth::routes();
