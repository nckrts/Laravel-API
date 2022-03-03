<?php

use App\Http\Controllers\Api\ClienteApiController;
//use Illuminate\Support\Facades\Route;


//Route::apiResource('clientes', ClienteApiController::class);
Route::GET('clientes',[ClienteApiController::class,'index']);
Route::GET('clientes/{id}',[ClienteApiController::class,'show']);
Route::POST('clientes',[ClienteApiController::class,'store']);
Route::put('clientes/{id}',[ClienteApiController::class,'update']);

