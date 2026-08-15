<?php

use App\Http\Controllers\Api\MenuItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — La Buena Mesa
|--------------------------------------------------------------------------
| En Laravel 12 este archivo se registra vía bootstrap/app.php:
|   ->withRouting(api: __DIR__.'/../routes/api.php', apiPrefix: 'api')
| Todas las rutas quedan bajo el prefijo /api automáticamente.
*/

Route::prefix('menu-items')->group(function () {
    // Ruta específica ANTES de la ruta con {id} para que "category" no
    // sea interpretado como un identificador numérico.
    Route::get('/category/{category}', [MenuItemController::class, 'byCategory']);
    
});

Route::apiResource('menu-items', MenuItemController::class);
