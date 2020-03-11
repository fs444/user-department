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

Route::get('/', 'UsersController@index');

Route::get('/home', function () {
    return redirect('/');
});

//Route::get('/departments', 'DepartmentsControllerNew@index');
//
//Route::get('/departments/create', 'DepartmentsControllerNew@create');
//
//Route::post('/departments', 'DepartmentsControllerNew@store');
//
//Route::get('/departments/{id}/edit', 'DepartmentsControllerNew@edit');
//
//Route::put('/departments/{id}', 'DepartmentsControllerNew@update');
//
//Route::delete('/departments/{id}', 'DepartmentsControllerNew@destroy');

Route::resource('departments', 'DepartmentsControllerNew');


//Route::get('/users', 'UserControllerNew@index');
//
//Route::get('/users/create', 'UserControllerNew@create');
//
//Route::post('/users', 'UserControllerNew@store');
//
//Route::get('/users/{id}/edit', 'UserControllerNew@edit');
//
//Route::put('/users/{id}', 'UserControllerNew@update');
//
//Route::delete('/users/{id}', 'UserControllerNew@destroy');

Route::resource('users', 'UserControllerNew');


Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');

Auth::routes();
