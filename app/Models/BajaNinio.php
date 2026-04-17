<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// CLAVE: No debes poner "use App\Models\BajaNinio;" aquí adentro.

class BajaNinio extends Model
{
    use HasFactory;

    protected $table = 'baja_ninios';
    
    protected $primaryKey = 'id_baja';
    
    public $timestamps = false;

    protected $fillable = [
        'id_ninio',
        'motivo',
        'fecha'
    ];

    /**
     * Relación con el modelo Ninio
     */
    public function ninio()
    {
        // Especificamos 'id_ninio' como llave foránea y local para que coincida con tu SQL
        return $this->belongsTo(Ninio::class, 'id_ninio', 'id_ninio');
    }
}