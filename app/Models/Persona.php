<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='personas';
    protected $primaryKey='id_persona';
    public $timestamps=false;
    protected $fillable=[
        'id_persona',
        'nom',
        'ap',
        'am',
        'fecha_nac'];

        public function ninio()
    {
        return $this->hasOne(Ninio::class, 'id_persona', 'id_persona');
    }
}
