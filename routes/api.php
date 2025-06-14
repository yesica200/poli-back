<?php

use App\Http\Controllers\Api\SafeCityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LecturaController;
use App\Http\Controllers\NotificacionController;
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
Route::post('/policias', [SafeCityController::class, 'crearPolicia']);
Route::get('/policias', [SafeCityController::class, 'obtenerPolicias']);
Route::delete('/policias/{id}', [SafeCityController::class, 'eliminarPolicia']);
Route::post('/guardar-token-push', [SafeCityController::class, 'guardarPushToken']);

Route::get('/ver-administradores', [LecturaController::class, 'administradores']);
Route::get('/ver-ciudadanos', [LecturaController::class, 'ciudadanos']);
Route::get('/ver-policias', [LecturaController::class, 'policias']);
Route::get('/ver-denuncias', [LecturaController::class, 'denuncias']);
Route::get('/ver-noticias', [LecturaController::class, 'noticias']);
Route::get('/ver-notificaciones', [LecturaController::class, 'notificaciones']);


Route::get('/notificaciones/sin-asignar', [NotificacionController::class, 'notificacionesSinAsignar']);
Route::post('/notificaciones/asignar/{id_policia}', [NotificacionController::class, 'asignarNotificacionesAPolicia']);
Route::get('/notificaciones/policia/{id_policia}', [NotificacionController::class, 'notificacionesPorPolicia']);
