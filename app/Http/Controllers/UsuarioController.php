<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function all()
    {
        $usuarios = Usuario::all();
        return $this->successResponse($usuarios);
    }
}
