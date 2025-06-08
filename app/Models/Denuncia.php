<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'denuncia';
    protected $primaryKey = 'id_denuncia';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'modulo_epi',
        'hora',
        'fecha',
        'tipo',
        'calle_avenida',
        'evidencia',
        'estado',
        'id_ciudadano',
        'id_policia',
        'fue_modificada',
    ];

    // Relaciones
    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class, 'id_ciudadano', 'id_ciudadano');
    }

    public function policia()
    {
        return $this->belongsTo(Policia::class, 'id_policia', 'id_policia');
    }
}
