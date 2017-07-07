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

//dummy privacy policy and terms-and-conditions for twitter
//not required here!!
Route::get('privacy', function (){
  return 'Privacy Policy';
});

Route::get('terms', function (){
  return 'Terms and Conditions';
});


Route::get('auth/{provider}', 'AuthProvidersController@redirectToProvider');
Route::get('auth/{provider}/callback', 'AuthProvidersController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login', 'Auth\LoginController@getLogin')->name('login');

Route::get('/register', 'Auth\RegisterController@getRegister')->name('register');
