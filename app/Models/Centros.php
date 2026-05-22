<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centros extends Model
{
    protected $table = 'centros';
    protected $primaryKey = 'id_centro';
    
    // Como mencionaste que no usas autoincremento y quieres control total
    public $timestamps = false;

    protected $fillable = [   
        'id_centro',
        'nom',
        'costo'
    ];

    /**
     * Relación: Un centro tiene muchos niños.
     */
    public function ninios()
    {
        return $this->hasMany(Ninio::class, 'id_centro');
    }

    /**
     * Método para la vista: {{ $centro->cantidad() }}
     * Cuenta los niños asociados a este centro.
     */
    public function cantidad()
    {
        // Verificamos si la clase Ninio existe para evitar errores
        if (class_exists('App\Models\Ninio')) {
            return $this->ninios()->count();
        }
        return 0; // Si no existe el modelo Ninio, muestra 0
    }

    /**
     * Método para la vista: {{ $centro->sumaTotal() }}
     * Calcula el total (por ahora lo dejamos en 0 o base al costo).
     */
    public function sumaTotal()
    {
        // Aquí podrías retornar el costo fijo o una suma de abonos
        // Por ahora regresamos 0 para cumplir con el método que pide la vista
        return 0;
    }
}