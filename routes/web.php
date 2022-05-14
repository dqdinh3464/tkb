<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name("home.index");
Route::get('/search', 'HomeController@xemTKB')->name("home.xem_tkb");
Route::get('/timetable', 'HomeController@timetable')->name("home.timetable");
Route::get('/upload', 'HomeController@upload')->name("home.upload");
Route::post('/upload', 'HomeController@uploadTKB')->name("home.upload_tkb");

Route::get('/upload-giang-vien', 'HomeController@uploadTKBGV')->name("home.upload.giang_vien");
Route::post('/upload-giang-vien', 'HomeController@uploadTKBGiangVien');
