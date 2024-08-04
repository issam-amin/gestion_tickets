<?php

use App\Http\Controllers\CommuneController;
use App\Http\Controllers\RegisseurController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TotalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home');
});
Route::controller(communeController::class)->group(function (){
        Route::get('/commune/{type}','index');
    Route::get('/commune/{region}/{id}', 'show');
    Route::get('{region}/{typeRegisseur}/{annee}', 'restToT');
});

Route::controller(RegisseurController::class)->group(function (){
    Route::post('/Regisseur/{nomCom}', 'index');
    Route::post('/Regisseur/chez_tp/{nomCom}', 'ChezTP');
    Route::post('/{typeRegisseur}/{annee}/{IDRegisseur}/{commune_Name}',  'store');
    Route::post('/show/{name}', 'show');
    Route::post('/type/{name}/{anne}', 'type');

});

Route::controller(TotalController::class)->group(function (){
    Route::get('/commune','index');
    Route::post('/Total/{typeRegisseur}/{annee}/{IDRegisseur}/{commune_Name}', 'store');
    Route::get('/Regisseur/{typeRegisseur}/{IDRegisseur}/{annee}', 'show');
    Route::get('/chezTp/{annee}/{commune_Name}', 'resteTP');
    Route::post('/choix', 'display');
});

Route::view('/Trecap','/TotalRecap/Trecap');
//Authentification
Route::get('/register',[RegisteredUserController::class, 'create']);
//->only(['create','store']
Route::post('/register',[RegisteredUserController::class, 'store']);


//login
Route::get('/login',[SessionController::class, 'create'])->name('login');
Route::post('/login',[SessionController::class, 'store']);
Route::post('/logout',[SessionController::class, 'destroy']);
