<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    protected $table = 'ciudadano';
    protected $primaryKey = 'id_ciudadano';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'contraseña',
    ];

    // Relaciones
    public function denuncias()
    {
        return $this->hasMany(Denuncia::class, 'id_ciudadano', 'id_ciudadano');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_ciudadano', 'id_ciudadano');
    }
}
