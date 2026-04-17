<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ninio extends Model
{
    protected $table = 'ninios';
    protected $primaryKey = 'id_ninio';
    public $timestamps = false;
    
    protected $fillable = [
        'matricula',
        'fecha',
        'id_persona',
        'id_centro'
    ];

    /**
     * Relación con el modelo Persona
     */
    public function persona()
    {
        // belongsTo(Modelo, llave_foranea, llave_primaria_de_persona)
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }
}