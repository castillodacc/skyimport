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
Route::group(['middleware' => 'auth'], function () {
	Route::group(['namespace' => 'Admin'], function () {
		Route::resource('usuarios', 'UsersController');
		Route::get('perfil/{id?}', 'UsersController@profile')->name('profile');
		Route::get('get-data-user', 'UsersController@dataForRegister');
		Route::post('save-image/{id?}', 'UsersController@saveImage');
		Route::post('change-password', 'UsersController@changePassword');
		Route::resource('envios', 'ConsolidatedController');
	});
    //    Route::get('/link1', function ()    {
	//        // Uses Auth Middleware
	//    });
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');