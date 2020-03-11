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

//Route::get('/', 'UserControllerNew@index');

Route::get('/', function () {
    return redirect('/users');
});

Route::get('/home', function () {
    return redirect('/users');
});

Route::resource('departments', 'DepartmentsControllerNew');

Route::resource('users', 'UserControllerNew');

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');

Auth::routes();
