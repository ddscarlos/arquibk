<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UbigeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API REST - ARQUITRACKING V1';
});

Route::prefix('v1')->group(function () {
    Route::prefix('empresa')->group(function () {
        Route::post('listar', [EmpresaController::class, 'sel']);
        Route::post('ins', [EmpresaController::class, 'ins']);
    });

    Route::prefix('general')->group(function () {
        Route::post('tipo-documento/listar', [GeneralController::class, 'tipodocumentosel']);
        Route::post('red-social/listar', [GeneralController::class, 'redsocialsel']);
        Route::post('estados/listar', [GeneralController::class, 'estadossel']);
    });

    Route::prefix('ubigeo')->group(function () {
        Route::post('departamento/listar', [UbigeoController::class, 'departamentosel']);
        Route::post('provincia/listar', [UbigeoController::class, 'provinciasel']);
        Route::post('distrito/listar', [UbigeoController::class, 'distritosel']);
    });

});
