<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Ciudadano;
use App\Models\Policia;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'
        ]);

        $ciudadano = Ciudadano::where('correo', $request->correo)
            ->where('contraseña', $request->contraseña)
            ->first();

        if ($ciudadano) {
            return response()->json([
                'success' => true,
                'message' => 'Login exitoso (ciudadano)',
                'usuario' => [
                    'id_ciudadano' => $ciudadano->id_ciudadano,
                    'nombres' => $ciudadano->nombres,
                    'apellido_paterno' => $ciudadano->apellido_paterno,
                    'apellido_materno' => $ciudadano->apellido_materno,
                    'correo' => $ciudadano->correo,
                    'nombreCompleto' => "{$ciudadano->nombres} {$ciudadano->apellido_paterno} {$ciudadano->apellido_materno}"
                ]
            ]);
        }

        $policia = Policia::where('correo', $request->correo)
            ->where('contraseña', $request->contraseña)
            ->first();

        if ($policia) {
            return response()->json([
                'success' => true,
                'message' => 'Login exitoso (policía)',
                'usuario' => [
                    'id_policia' => $policia->id_policia,
                    'nombres' => $policia->nombres,
                    'apellido_paterno' => $policia->apellido_paterno,
                    'apellido_materno' => $policia->apellido_materno,
                    'correo' => $policia->correo,
                    'nombreCompleto' => "{$policia->nombres} {$policia->apellido_paterno} {$policia->apellido_materno}"
                ]
            ]);
        }

        $admin = Administrador::where('correo', $request->correo)
            ->where('contraseña', $request->contraseña)
            ->first();

        if ($admin) {
            return response()->json([
                'success' => true,
                'message' => 'Login exitoso (administrador)',
                'usuario' => [
                    'id_admin' => $admin->id_admin,
                    'correo' => $admin->correo
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ], 401);
    }
}
