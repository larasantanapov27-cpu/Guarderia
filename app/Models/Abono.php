<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $table='abonos';
    protected $primaryKey='id_abono';
    public $timestamps=false;
    protected $fillable=[
    'id_abono',
    'cantidad',
    'fecha',
    'id_regcuenta'];
}
