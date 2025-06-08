<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policia extends Model
{
    protected $table = 'policia';
    protected $primaryKey = 'id_policia';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'contraseña',
        'id_admin',
    ];

    // Relaciones
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin', 'id_admin');
    }

    public function denuncias()
    {
        return $this->hasMany(Denuncia::class, 'id_policia', 'id_policia');
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'id_policia', 'id_policia');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_policia', 'id_policia');
    }
}
