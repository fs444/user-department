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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', function () {
    return redirect('/');
});

Route::prefix('departments')->group(function () {

    Route::get('/', 'DepartmentsController@index');

    Route::get('add', 'DepartmentsController@add');

    Route::any('create', 'DepartmentsController@create');

    Route::get('delete/{department_id}', 'DepartmentsController@delete');

    Route::get('edit/{department_id}', 'DepartmentsController@edit');

    Route::any('update', 'DepartmentsController@update');
});

Route::prefix('users')->group(function () {

    Route::get('/', 'UsersController@index');

    Route::any('add', 'UsersController@add');

    Route::any('create', 'UsersController@create');

    Route::get('delete/{user_id}', 'UsersController@delete');

    Route::get('edit/{user_id}', 'UsersController@edit');

    Route::any('update', 'UsersController@update');

});

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');


Auth::routes();
