<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Ciudadano;
use App\Models\Denuncia;
use App\Models\Noticia;
use App\Models\Notificacion;
use App\Models\Policia;
use Illuminate\Http\Request;

class LecturaController extends Controller
{
    public function administradores()
    {
        return response()->json(Administrador::all());
    }

    public function ciudadanos()
    {
        return response()->json(Ciudadano::all());
    }

    public function policias()
    {
        return response()->json(Policia::all());
    }

    public function denuncias()
    {
        return response()->json(Denuncia::all());
    }

    public function noticias()
    {
        return response()->json(Noticia::all());
    }

    public function notificaciones()
    {
        return response()->json(Notificacion::all());
    }
}
