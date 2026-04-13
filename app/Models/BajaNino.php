<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BajaNinio extends Model
{
    use HasFactory; // Recomendado para poder usar seeders y factories

    protected $table = 'baja_ninios';
    
    protected $primaryKey = 'id_baja';
    
    public $timestamps = false;

    // Eliminamos 'id_baja' de aquí, ya que es autoincremental
    protected $fillable = [
        'id_ninio',
        'motivo',
        'fecha'
    ];

    /**
     * Relación con el modelo Ninio
     * Esto te permitirá hacer cosas como $baja->ninio->matricula
     */
    public function ninio()
    {
        return $this->belongsTo(Ninio::class, 'id_ninio');
    }
}