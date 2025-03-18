<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master');
});

Route::post('/generar','Controlador@create');

Route::get('download/{filename}','Controlador@download')->name("download");
//Route::get('download','Controlador@download')->name("download");