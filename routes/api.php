<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/articulos', 'App\Http\Controllers\ArticuloControllers@index'); // mostrar todos los registros
// Route::post('/articulos', 'App\Http\Controllers\ArticuloControllers@store'); // crear un registro
// Route::put('/articulos/{id}', 'App\Http\Controllers\ArticuloControllers@update'); // actualizar un registro
// Route::delete('/articulos/{id}', 'App\Http\Controllers\ArticuloControllers@destroy'); // crear un registro




Route::group(['middleware' => ['web']], function () {
    // your routes here
    // LOGIN
    // Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    // CATEGORIAS
    Route::get('/categoria', [CategoryController::class,'index']);
    Route::get('/categoria-listar-todas', [CategoryController::class,'indexAll']);
    Route::post('/categoria', [CategoryController::class,'create']);
    Route::get('/categoria/{id}', [CategoryController::class,'show']);
    Route::put('/categoria/{id}', [CategoryController::class,'edit']);
    Route::delete('/categoria/{id}', [CategoryController::class,'destroy']);

    // SUBCATEGORIAS
    Route::get('/subcategoria-listar/{id}', [SubcategoryController::class,'index']);
    Route::get('/subcategoria-listar-todas', [SubcategoryController::class,'indexAll']);
    Route::post('/subcategoria', [SubcategoryController::class,'create']);
    Route::get('/subcategoria/{id}', [SubcategoryController::class,'show']);
    Route::put('/subcategoria/{id}', [SubcategoryController::class,'edit']);
    Route::delete('/subcategoria/{id}', [SubcategoryController::class,'destroy']);

    // PRODUCTOS
    Route::get('/producto', [ProductController::class,'index']);
    Route::post('/producto', [ProductController::class,'create']);
    Route::get('/producto/{id}', [ProductController::class,'show']);
    Route::put('/producto/{id}', [ProductController::class,'edit']);
    Route::delete('/producto/{id}', [ProductController::class,'destroy']);

    // MESAS
    Route::get('/mesa', [TableController::class,'index']);
    Route::post('/mesa', [TableController::class,'create']);
    Route::get('/mesa/{id}', [TableController::class,'show']);
    Route::get('/generarqr/{id}', [TableController::class,'generarQR']);
    Route::put('/mesa/{id}', [TableController::class,'edit']);
    Route::delete('/mesa/{id}', [TableController::class,'destroy']);

    // MESAS
    Route::post('/orden', [OrderController::class,'create']);
    Route::get('/orden/{id}', [OrderController::class,'show']);

    // RESEÑAS
    Route::get('/resenia', [ReviewController::class,'index']);
    Route::post('/resenia', [ReviewController::class,'create']);
    Route::get('/resenia/{id}', [ReviewController::class,'show']);

 
    // MI CUENTA
    Route::get('/mi-cuenta/obtenerDatos/{id}', [LoginController::class,'getDatos']);







    


});
