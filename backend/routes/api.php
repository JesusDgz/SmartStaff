<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertaController;


Route::post('/alerta-ubicacion', [AlertaController::class, 'enviarUbicacion']);



Route::get('/prueba', function () {
    return '✅ Laravel está funcionando correctamente';
});

