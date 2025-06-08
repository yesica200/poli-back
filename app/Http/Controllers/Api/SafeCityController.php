<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciudadano;
use App\Models\Denuncia;
use App\Models\Noticia;
use App\Models\Policia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SafeCityController extends Controller
{
    public function registro(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        if (Ciudadano::where('correo', $validated['correo'])->exists()) {
            return response()->json(['success' => false, 'message' => 'El correo electrónico ya está registrado'], 400);
        }

        $ciudadano = Ciudadano::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'ciudadanoId' => $ciudadano->id_ciudadano
        ]);
    }

    public function crearDenuncia(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'modulo_epi' => 'required|string',
            'hora' => 'required',
            'fecha' => 'required|date',
            'tipo' => 'required|string',
            'calle_avenida' => 'required|string',
            'id_ciudadano' => 'required|exists:ciudadano,id_ciudadano',
            'evidencia' => 'nullable|string'
        ]);

        $denuncia = Denuncia::create([
            ...$validated,
            'estado' => 'PENDIENTE'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Denuncia registrada exitosamente',
            'denunciaId' => $denuncia->id_denuncia
        ]);
    }

    public function crearNoticia(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
            'hora' => 'required',
            'fecha' => 'required|date',
            'idPolicia' => 'required|exists:policia,id_policia',
            'imagen' => 'nullable|string'
        ]);

        if ($validated['imagen'] && !str_starts_with($validated['imagen'], 'https://res.cloudinary.com/')) {
            return response()->json(['success' => false, 'message' => 'Formato de imagen no válido. Debe ser una URL de Cloudinary'], 400);
        }

        $noticia = Noticia::create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'hora' => $validated['hora'],
            'fecha' => $validated['fecha'],
            'imagen' => $validated['imagen'] ?? null,
            'id_policia' => $validated['idPolicia'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Noticia registrada exitosamente',
            'noticiaId' => $noticia->id_noticia
        ]);
    }

    public function casosPendientes()
    {
        $casos = Denuncia::select('denuncia.*', DB::raw("CONCAT(ciudadano.nombres, ' ', ciudadano.apellido_paterno, ' ', ciudadano.apellido_materno) AS nombre_denunciante"))
            ->join('ciudadano', 'denuncia.id_ciudadano', '=', 'ciudadano.id_ciudadano')
            ->where('denuncia.estado', 'PENDIENTE')
            ->orderByRaw("
                CASE denuncia.tipo
                    WHEN 'ASESINATO' THEN 1
                    WHEN 'asalto' THEN 2
                    WHEN 'accidente de transito' THEN 3
                    ELSE 4
                END, denuncia.fecha DESC, denuncia.hora DESC
            ")
            ->get();

        return response()->json($casos);
    }

    public function atenderDenuncia(Request $request)
    {
        $id = $request->idDenuncia;
        $denuncia = Denuncia::find($id);
        if (!$denuncia) {
            return response()->json(['error' => 'Denuncia no encontrada'], 404);
        }

        $denuncia->estado = 'ATENDIDO';
        $denuncia->save();

        return response()->json($denuncia);
    }

    public function denunciasAtendidas()
    {
        $denuncias = Denuncia::select('denuncia.*', DB::raw("CONCAT(ciudadano.nombres, ' ', ciudadano.apellido_paterno, ' ', ciudadano.apellido_materno) AS nombre_denunciante"))
            ->join('ciudadano', 'denuncia.id_ciudadano', '=', 'ciudadano.id_ciudadano')
            ->where('denuncia.estado', 'ATENDIDO')
            ->orderByDesc('denuncia.fecha')
            ->orderByDesc('denuncia.hora')
            ->get();

        return response()->json($denuncias);
    }

    public function actualizarPerfil(Request $request)
    {
        $validated = $request->validate([
            'id_ciudadano' => 'required|exists:ciudadano,id_ciudadano',
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email',
        ]);

        if (Ciudadano::where('correo', $validated['correo'])->where('id_ciudadano', '!=', $validated['id_ciudadano'])->exists()) {
            return response()->json(['success' => false, 'message' => 'El correo electrónico ya está registrado por otro usuario'], 400);
        }

        $ciudadano = Ciudadano::find($validated['id_ciudadano']);
        $ciudadano->update($validated);

        return response()->json(['success' => true, 'message' => 'Perfil actualizado exitosamente']);
    }

    public function denunciasAtendidasUsuario($idCiudadano)
    {
        $denuncias = Denuncia::where('estado', 'ATENDIDO')->where('id_ciudadano', $idCiudadano)
            ->orderByDesc('fecha')->orderByDesc('hora')->get();
        return response()->json($denuncias);
    }

    public function denunciasPendientesUsuario($idCiudadano)
    {
        $denuncias = Denuncia::where('estado', 'PENDIENTE')->where('id_ciudadano', $idCiudadano)
            ->orderByDesc('fecha')->orderByDesc('hora')->get();
        return response()->json($denuncias);
    }

    public function mostrarDenuncia($idDenuncia)
    {
        $denuncia = Denuncia::find($idDenuncia);
        if (!$denuncia) {
            return response()->json(['success' => false, 'message' => 'Denuncia no encontrada'], 404);
        }
        return response()->json(['success' => true, 'denuncia' => $denuncia]);
    }

    public function actualizarDenuncia(Request $request, $idDenuncia)
    {
        $denuncia = Denuncia::find($idDenuncia);
        if (!$denuncia) {
            return response()->json(['success' => false, 'message' => 'Denuncia no encontrada'], 404);
        }
        if ($denuncia->fue_modificada) {
            return response()->json(['success' => false, 'message' => 'Esta denuncia ya fue modificada anteriormente'], 400);
        }
        if ($denuncia->estado !== 'PENDIENTE') {
            return response()->json(['success' => false, 'message' => 'Solo se pueden modificar denuncias pendientes'], 400);
        }
        
        $request->validate([
            'descripcion' => 'required|string',
            'modulo_epi' => 'required|string',
            'hora' => 'required',
            'fecha' => 'required|date',
            'tipo' => 'required|string',
            'calle_avenida' => 'required|string',
            'evidencia' => 'nullable|string'
        ]);
        $denuncia->update([
            'descripcion' => $request->descripcion,
            'modulo_epi' => $request->modulo_epi,
            'hora' => $request->hora,
            'fecha' => $request->fecha,
            'tipo' => $request->tipo,
            'calle_avenida' => $request->calle_avenida,
            'evidencia' => $request->evidencia,
            'fue_modificada' => 1
        ]);
        return response()->json(['success' => true, 'message' => 'Denuncia actualizada exitosamente']);
    }

    public function todasNoticias()
    {
        $noticias = Noticia::select('noticia.*', DB::raw("CONCAT(policia.nombres, ' ', policia.apellido_paterno, ' ', policia.apellido_materno) AS nombre_policia"))
            ->join('policia', 'noticia.id_policia', '=', 'policia.id_policia')
            ->orderByDesc('noticia.fecha')->orderByDesc('noticia.hora')
            ->get()
            ->map(function ($noticia) {
                $noticia->imagen = $noticia->imagen ?: null;
                return $noticia;
            });
        return response()->json($noticias);
    }

    public function noticiasCategoria($categoria)
    {
        $query = Noticia::select('noticia.*', DB::raw("CONCAT(policia.nombres, ' ', policia.apellido_paterno, ' ', policia.apellido_materno) AS nombre_policia"))
            ->join('policia', 'noticia.id_policia', '=', 'policia.id_policia');
        $cat = strtolower($categoria);
        if ($cat === 'robos') {
            $query->where(function ($q) {
                $q->whereRaw('LOWER(noticia.titulo) LIKE ?', ['%robo%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%robo%']);
            });
        } elseif ($cat === 'accidentes') {
            $query->where(function ($q) {
                $q->whereRaw('LOWER(noticia.titulo) LIKE ?', ['%accidente%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%accidente%'])
                    ->orWhereRaw('LOWER(noticia.titulo) LIKE ?', ['%tránsito%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%tránsito%']);
            });
        } elseif ($cat === 'alertas') {
            $query->where(function ($q) {
                $q->whereRaw('LOWER(noticia.titulo) LIKE ?', ['%alerta%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%alerta%'])
                    ->orWhereRaw('LOWER(noticia.titulo) LIKE ?', ['%emergencia%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%emergencia%']);
            });
        }
        $noticias = $query->orderByDesc('noticia.fecha')->orderByDesc('noticia.hora')->get()
            ->map(function ($noticia) {
                $noticia->imagen = $noticia->imagen ?: null;
                return $noticia;
            });
        return response()->json($noticias);
    }

    public function estadisticasNoticias()
    {
        $stats = Noticia::selectRaw("
            COUNT(*) as total_noticias,
            COUNT(CASE WHEN LOWER(titulo) LIKE '%robo%' OR LOWER(descripcion) LIKE '%robo%' THEN 1 END) as robos,
            COUNT(CASE WHEN LOWER(titulo) LIKE '%accidente%' OR LOWER(descripcion) LIKE '%accidente%' THEN 1 END) as accidentes,
            COUNT(CASE WHEN LOWER(titulo) LIKE '%alerta%' OR LOWER(descripcion) LIKE '%alerta%' THEN 1 END) as alertas,
            DATE(MAX(fecha)) as ultima_noticia
        ")->first();
        return response()->json($stats);
    }

    public function buscarNoticias($texto)
    {
        $noticias = Noticia::select('noticia.*', DB::raw("CONCAT(policia.nombres, ' ', policia.apellido_paterno, ' ', policia.apellido_materno) AS nombre_policia"))
            ->join('policia', 'noticia.id_policia', '=', 'policia.id_policia')
            ->where(function ($q) use ($texto) {
                $q->whereRaw('LOWER(noticia.titulo) LIKE ?', ['%' . strtolower($texto) . '%'])
                    ->orWhereRaw('LOWER(noticia.descripcion) LIKE ?', ['%' . strtolower($texto) . '%']);
            })
            ->orderByDesc('noticia.fecha')->orderByDesc('noticia.hora')
            ->get()
            ->map(function ($noticia) {
                $noticia->imagen = $noticia->imagen ?: null;
                return $noticia;
            });
        return response()->json($noticias);
    }

    public function crearPolicia(Request $request)
    {
        $validated =  $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email|unique:policia,correo',
            'contraseña' => 'required|string',
            'id_admin' => 'required|exists:administrador,id_admin'
        ]);

        $policia = Policia::create([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña,
            'id_admin' => $request->id_admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Policía registrado exitosamente',
            'policia' => $policia
        ]);
    }

    public function obtenerPolicias()
    {
        $policias = Policia::all();
        return response()->json($policias);
    }

    public function eliminarPolicia($id)
    {
        $policia = Policia::find($id);

        if (!$policia) {
            return response()->json([
                'success' => false,
                'message' => 'Policía no encontrado'
            ], 404);
        }

        $policia->delete();

        return response()->json([
            'success' => true,
            'message' => 'Policía eliminado exitosamente'
        ]);
    }
}
