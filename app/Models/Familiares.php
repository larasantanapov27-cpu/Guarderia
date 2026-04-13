<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familiares extends Model
{
    protected $table='familiares';
    protected $primaryKey='id_fam';
    public $timestamps=false;
    protected $fillable=[
            'id_fam',
            'id_persona',
            'DNI',
            'dir',
            'id_parentezco',
            'id_ninio'];
}
