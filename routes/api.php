<?php

use App\Http\Controllers\Api\SafeCityController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/registro', [SafeCityController::class, 'registro']);
Route::post('/denuncias', [SafeCityController::class, 'crearDenuncia']);
Route::post('/noticias', [SafeCityController::class, 'crearNoticia']);
Route::get('/casosPendientes', [SafeCityController::class, 'casosPendientes']);
Route::post('/atenderDenuncia', [SafeCityController::class, 'atenderDenuncia']);
Route::get('/denunciasAtendidas', [SafeCityController::class, 'denunciasAtendidas']);
Route::put('/perfil', [SafeCityController::class, 'actualizarPerfil']);
Route::get('/denunciasUsuario/atendidas/{idCiudadano}', [SafeCityController::class, 'denunciasAtendidasUsuario']);
Route::get('/denunciasUsuario/pendientes/{idCiudadano}', [SafeCityController::class, 'denunciasPendientesUsuario']);
Route::get('/denuncia/{idDenuncia}', [SafeCityController::class, 'mostrarDenuncia']);
Route::put('/denuncia/{idDenuncia}', [SafeCityController::class, 'actualizarDenuncia']);
Route::get('/noticias', [SafeCityController::class, 'todasNoticias']);
Route::get('/noticias/categoria/{categoria}', [SafeCityController::class, 'noticiasCategoria']);
Route::get('/noticias/estadisticas', [SafeCityController::class, 'estadisticasNoticias']);
Route::get('/noticias/buscar/{texto}', [SafeCityController::class, 'buscarNoticias']);
