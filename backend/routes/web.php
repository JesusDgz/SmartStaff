<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertaController;




Route::middleware([])->prefix('api')->group(function () {

});

Route::get('/prueba', function () {
    return '✅ Laravel está funcionando correctamente';
});

