<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DireccionGruposPrioritariosController extends Controller
{
    public function menu()
    {
        return view('direccion_grupos_prioritarios.menu');
    }
}
