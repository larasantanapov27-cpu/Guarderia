<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table='menus';
    protected $primaryKey='id_menu';
    public $timestamps=false;
    protected $fillable=[
        'id_menu',
        'id_plato',
        'id_ingrediente'];
}
