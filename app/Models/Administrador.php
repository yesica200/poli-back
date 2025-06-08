<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
   
    protected $table = 'administrador';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'correo',
        'contraseña',
    ];

    // Relación: un administrador tiene muchos policías
    public function policias()
    {
        return $this->hasMany(Policia::class, 'id_admin', 'id_admin');
    }
}
