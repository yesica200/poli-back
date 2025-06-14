<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function notificacionesSinAsignar()
    {
        $notificaciones = Notificacion::whereNull('id_policia')->get();
        return response()->json($notificaciones);
    }

    public function asignarNotificacionesAPolicia($id_policia)
    {
        $notificaciones = Notificacion::whereNull('id_policia')->get();

        foreach ($notificaciones as $notificacion) {
            $notificacion->update(['id_policia' => $id_policia]);
        }

        return response()->json($notificaciones);
    }

    public function notificacionesPorPolicia($id_policia)
    {
        $notificaciones = Notificacion::where('id_policia', $id_policia)->get();
        return response()->json($notificaciones);
    }
}
