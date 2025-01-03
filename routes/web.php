<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API REST - ERP V1';
});

Route::prefix('v1')->group(function () {
    Route::prefix('calendario')->group(function () {
        // Route::post('areaoficina/listar', [SigtaController::class, 'listarAreaOficina']);
        Route::post('listar-menu', [CalendarioController::class, 'listarMenu']);
        Route::post('usuario/ingresar', [CalendarioController::class, 'ingresarUsuario']);
        Route::post('usuario/listar', [CalendarioController::class, 'listarUsuario']);

        Route::post('eventos/listar', [CalendarioController::class, 'listarEventos']);
        Route::post('eventos/registrar', [CalendarioController::class, 'registrarEventos']);
        Route::post('eventos/anular', [CalendarioController::class, 'anularEventos']);
        Route::post('eventos/uploadFilesArchivos', [CalendarioController::class, 'uploadFilesArchivos']);
        Route::post('eventos/Archivossel', [CalendarioController::class, 'archivosSel']);
        Route::post('eventos/visualizarArchivos', [CalendarioController::class, 'getvisualizarArchivos']);
        Route::post('eventos/eliminararchivos', [CalendarioController::class, 'eliminararchivos']);
    });

    Route::prefix('user')->group(function () {
         Route::post('login', [UsuarioController::class, 'login']);
    });
});
