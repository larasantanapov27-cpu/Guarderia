<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroComida extends Model
{
    protected $table='registro_comidas';
    protected $primaryKey='id_registrocomida';
    public $timestamps=false;
    protected $fillable=[
        'id_registrocomida',
        'id_ninio',
        'id_plato',
        'fecha',
        'cantidad',];
}
