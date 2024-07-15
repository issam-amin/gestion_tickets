<?php

use App\Http\Controllers\CuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home');
});
Route::controller(CuController::class)->group(function (){
    Route::get('/Cu','index');
    Route::get('/Cu/{cu_name}', 'show');
    Route::get('/Cu/{cu_name}/{name}', 'tableau');
    Route::get('/Cu/{cu_name}/{name}/{month}', 'mois');
});
Route::resource('/makerg',\App\Http\Controllers\RegisseurController::class);
Route::view('/CR','CR');
