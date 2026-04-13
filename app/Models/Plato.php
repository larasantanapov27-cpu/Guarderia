<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    protected $table='platos';
    protected $primaryKey='id_plato';
    public $timestamps=false;
    protected $fillable=[
        'id_plato',
        'nombre',
        'precio'];
}
