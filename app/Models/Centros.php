<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centros extends Model
{
    protected $table='centros';
    protected $primaryKey='id_centro';
    public $timestamps=false;
    protected $fillable=[   
    'id_centro',
    'nom',
    'costo'];
}
