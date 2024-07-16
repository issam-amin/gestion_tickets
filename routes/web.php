<?php

use App\Http\Controllers\CuController;
use App\Http\Controllers\RegisseurController;
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
    Route::post('/approvisionnement/{annee}/{IDRegisseur}',  'store');

});


Route::view('/CR','CR');
