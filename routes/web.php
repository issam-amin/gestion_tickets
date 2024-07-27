<?php

use App\Http\Controllers\CommuneController;
use App\Http\Controllers\RegisseurController;
use App\Http\Controllers\TotalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home');
});
Route::controller(communeController::class)->group(function (){
    Route::get('/commune/{type}','index');
    Route::get('/commune/{region}/{id}', 'show');
});

Route::controller(RegisseurController::class)->group(function (){
    Route::post('/Regisseur/{nomCom}', 'index');
    Route::post('/{typeRegisseur}/{annee}/{IDRegisseur}',  'store');
    Route::post('/show/{name}', 'show');

});

Route::controller(TotalController::class)->group(function (){
    Route::get('/commune','index');
    Route::post('/Total/{typeRegisseur}/{annee}/{IDRegisseur}', 'store');
    Route::get('/Regisseur/{IDRegisseur}/{annee}', 'show');
    Route::get('/Regisseur/chezTp/{IDRegisseur}/{annee}/{name}', 'resteTP');
    Route::post('/choix', 'display');
});

Route::view('/Trecap','/TotalRecap/Trecap');

