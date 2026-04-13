<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parentezco extends Model
{
    protected $table='parentezcos';
    protected $primaryKey='id_parentezco';
    public $timestamps=false;
    protected $fillable=[
    'id_parentezco',
    'nombre'];
}
