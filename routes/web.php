<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\UsuarioController;

Route::get('/usuarios', [UsuarioController::class,'all']);
