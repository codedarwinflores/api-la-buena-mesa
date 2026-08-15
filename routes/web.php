<?php

use App\Http\Controllers\Api\MenuItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Vista de administración del menú. Es un cliente que consume la propia
| API RESTful vía fetch() desde el navegador — sirve como demo funcional
| y como documentación viva de los endpoints.
*/

Route::view('/', 'menu.index')->name('menu.index');
Route::get('/docs', [MenuItemController::class, 'docs']);