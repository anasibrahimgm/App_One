<?php

// Email confirmation
Route::get('confirmation/resend', 'Auth\RegisterController@resend')->name('confirmation.resend');
Route::get('confirmation/{id}/{token}', 'Auth\RegisterController@confirm');
