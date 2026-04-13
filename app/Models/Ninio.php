<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ninio extends Model
{
    protected $table='ninios';
    protected $primaryKey='id_ninio';
    public $timestamps=false;
    protected $fillable=[
        'id_ninio',
        'matricula',
        'fecha',
        'id_persona',
        'id_centro'];
}
