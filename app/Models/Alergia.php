<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $table='alergias';
    protected $primaryKey='id_alergia';
    public $timestamps=false;
    protected $fillable=[
        'id_alergia',
        'id_ingrediente',
        'id_ninio'];
}
