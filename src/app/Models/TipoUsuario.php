<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class TipoUsuario extends Model
{
    protected $table = 'tipo_usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 
        'sigla'
    ];

}
