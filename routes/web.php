<?php

use Illuminate\Support\Facades\Route;

Route::get('/upload', 'HomeController@upload')->name("home.upload");
Route::post('/upload', 'HomeController@uploadTKB')->name("home.upload_tkb");
