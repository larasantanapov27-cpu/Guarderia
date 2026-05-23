<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroComida extends Model
{
    // Nombre de la tabla asociada en la base de datos
    protected $table = 'registro_comidas';

    // Llave primaria real de la tabla
    protected $primaryKey = 'id_registrocomida';

    // Desactivamos los campos automáticos 'created_at' y 'updated_at'
    public $timestamps = false;

    /**
     * Atributos que se pueden asignar de forma masiva de manera segura.
     * (Se remueve 'id_registrocomida' porque lo gestiona el AUTO_INCREMENT de MySQL)
     */
    protected $fillable = [
        'id_ninio',
        'id_plato',
        'fecha',
        'cantidad',
    ];
}