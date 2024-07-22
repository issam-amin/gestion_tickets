<?php

use App\Http\Controllers\CuController;
use App\Http\Controllers\RegisseurController;
use App\Http\Controllers\TotalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home');
});
Route::controller(CuController::class)->group(function (){
    Route::get('/Cu','index');
    Route::get('/Cu/{cu_name}', 'show');


});
Route::controller(RegisseurController::class)->group(function (){
    Route::post('/Regisseur', 'index');
    Route::post('/{typeRegisseur}/{annee}/{IDRegisseur}',  'store');
    Route::post('/show/{cu_name}', 'show');

});
Route::controller(TotalController::class)->group(function (){
    Route::get('/commune','index');
    Route::post('/Total/{typeRegisseur}/{annee}/{IDRegisseur}', 'store');
    Route::get('/Regisseur/{IDRegisseur}/{annee}', 'show');
    Route::post('/choix', 'display');
});
Route::view('/Trecap','/TotalRecap/Trecap');
Route::view('/CR','CR');
