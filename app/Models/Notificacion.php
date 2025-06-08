<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'hora',
        'fecha',
        'id_policia',
        'id_ciudadano',
    ];

    // Relaciones
    public function policia()
    {
        return $this->belongsTo(Policia::class, 'id_policia', 'id_policia');
    }

    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class, 'id_ciudadano', 'id_ciudadano');
    }
}
