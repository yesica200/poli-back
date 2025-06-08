<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = 'noticia';
    protected $primaryKey = 'id_noticia';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'hora',
        'fecha',
        'imagen',
        'categoria',
        'id_policia',
    ];

    // Relaciones
    public function policia()
    {
        return $this->belongsTo(Policia::class, 'id_policia', 'id_policia');
    }
}
