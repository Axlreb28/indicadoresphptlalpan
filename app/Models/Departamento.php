<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Departamento extends Authenticatable
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $fillable = ['ID', 'Departamento', 'Contraseña', 'VistaEspecial'];

    public $timestamps = false;
    protected $primaryKey = 'ID';
}
