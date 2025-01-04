<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API REST - ARQUITRACKING V1';
});

Route::prefix('v1')->group(function () {
    Route::prefix('empresa')->group(function () {
        //Route::post('eventos/eliminararchivos', [CalendarioController::class, 'eliminararchivos']);
        Route::post('listar', [EmpresaController::class, 'sel']);
        Route::post('ins', [EmpresaController::class, 'ins']);
    });

    Route::prefix('general')->group(function () {
        Route::post('tipo-documento/listar', [GeneralController::class, 'tipodocumentosel']);
    });

});
