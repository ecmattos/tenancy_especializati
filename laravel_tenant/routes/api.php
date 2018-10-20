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
*/

Route::group(['middleware' => 'cors', 'as' => 'api.'], function(){
	Route::post('login', 'Api\AuthController@login')->name('login');
	Route::post('register', 'Api\AuthController@register')->name('register');
	Route::post('registerAdmin', 'Api\AuthController@registerAdmin')->name('registerAdmin');
	Route::post('recovery', 'Api\AuthController@recovery')->name('recovery');
	Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
	Route::post('verify', 'Api\AuthController@verify')->name('verify');
	Route::post('refresh', 'Api\AuthController@refresh')->name('refresh');

	Route::group(['prefix' => 'clients'], function () {
		Route::post('/', 'Api\ClientsController@store')->name('clients.store');
		#Route::post('/', 'Api\ClientsController@verify')->name('clients.verify');
	});

	Route::group(['prefix' => 'plans'], function () {
		Route::get('/', 'Api\PlansController@index')->name('plans');
	});

	Route::group(['prefix' => 'materials'], function () {
		Route::get('/', 'Api\Tenant\MaterialsController@index')->name('materials');
		Route::get('/{id}/show', 'Api\Tenant\MaterialsController@show')->name('materials.show');
	});

	Route::group(['prefix' => 'material_units'], function () {
		Route::get('/', 'Api\MaterialUnitsController@index')->name('material_units');
		Route::get('/{id}/show', 'Api\MaterialUnitsController@show')->name('material_units.show');
	});

	Route::group(['prefix' => 'company_positions'], function () {
		Route::get('/', 'Api\CompanyPositionsController@index')->name('company_positions');
		Route::get('/{id}/show', 'Api\CompanyPositionsController@show')->name('company_positions.show');
	});
});

Route::group(['middleware' => 'jwt.auth'], function(){
	Route::group(['middleware' => 'cors', 'as' => 'api.'], function(){
		Route::post('logout', 'Api\AuthController@logout')->name('logout');		
		
		Route::group(['prefix' => 'materials'], function () {
			//Route::get('/', 'Api\Tenant\MaterialsController@index')->name('materials');
			Route::post('/searchCode', 'Api\Tenant\MaterialsController@searchCode')->name('materials.searchCode');
			Route::post('/searchDescription', 'Api\Tenant\MaterialsController@searchDescription')->name('materials.searchDescription');
			//Route::get('/create', 'Api\Tenant\MaterialsController@create')->name('materials.create');
			//Route::get('/{id}/show', 'Api\Tenant\MaterialsController@show')->name('materials.show');
			//Route::get('/{id}/edit', 'Api\Tenant\MaterialsController@edit')->name('materials.edit');
			Route::get('/{id}/destroy', 'Api\Tenant\MaterialsController@destroy')->name('materials.destroy');
			Route::put('/{id}/update', 'Api\Tenant\MaterialsController@update')->name('materials.update');
			Route::post('/', 'Api\Tenant\MaterialsController@store')->name('materials.store');
		});

		Route::group(['prefix' => 'plans'], function () {
			Route::get('/', 'Api\PlansController@index')->name('plans');
			Route::post('/searchCode', 'Api\PlansController@searchCode')->name('plans.searchCode');
			Route::post('/searchDescription', 'Api\PlansController@searchDescription')->name('plans.searchDescription');
			Route::get('/create', 'Api\PlansController@create')->name('plans.create');
			Route::get('/{id}/show', 'Api\PlansController@show')->name('plans.show');
			Route::get('/{id}/edit', 'Api\PlansController@edit')->name('plans.edit');
			Route::get('/{id}/destroy', 'Api\PlansController@destroy')->name('plans.destroy');
			Route::put('/{id}/update', 'Api\PlansController@update')->name('plans.update');
			Route::post('/', 'Api\PlansController@store')->name('plans.store');
		});
		
		Route::group(['prefix' => 'products'], function () {
			Route::get('/', 'Api\ProductsController@index')->name('products');
			Route::post('/searchCode', 'Api\ProductsController@searchCode')->name('products.searchCode');
			Route::post('/searchDescription', 'Api\ProductsController@searchDescription')->name('products.searchDescription');
			Route::get('/create', 'Api\ProductsController@create')->name('products.create');
			Route::get('/{id}/show', 'Api\ProductsController@show')->name('products.show');
			Route::get('/{id}/edit', 'Api\ProductsController@edit')->name('products.edit');
			Route::get('/{id}/destroy', 'Api\ProductsController@destroy')->name('products.destroy');
			Route::put('/{id}/update', 'Api\ProductsController@update')->name('products.update');
			Route::post('/', 'Api\ProductsController@store')->name('products.store');
		});
	});
});



