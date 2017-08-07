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

Route::get('users/{username}', 'ProfilesController@show')->name('users.show');
Route::get('editProfile', 'ProfilesController@edit')->name('editProfile');
Route::put('updateProfile', 'ProfilesController@update')->name('updateProfile');
Route::delete('deleteProfile', 'ProfilesController@destroy')->name('deleteProfile');

Route::resource('posts', 'PostsController');
Route::get('userPosts/{user_id}', 'PostsController@userPosts');

// if we wanted to logOut only admins
Route::post('user/logout', 'Auth\LoginController@userLogout')->name('logout');

Route::prefix('/admin')->group(function(){
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  Route::get('/login', 'Auth\AdminLoginController@showLogin')->name('admin.showLogin');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
  // if we wanted to logOut only admins
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  Route::prefix('/password')->group(function() {
    Route::get('reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('reset', 'Auth\AdminResetPasswordController@reset');
  });

});

Route::get('anas', function() {
  return view('posts.create');
});


Route::post('test', 'PostsController@test');
