<?php

use App\Http\Controllers\GrupoProdutoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TipoProdutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/usuarios', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']],  function () {
    //usuarios
    Route::get('/usuarios', [UserController::class, 'all']);
    Route::get('/usuarios/{id}', [UserController::class, 'one']);
    Route::post('/usuarios', [UserController::class, 'create']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']);
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logout'], 200);
    })->name('logout');

    //produtos
    Route::get('/produtos', [ProdutoController::class, 'all']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'one']);
    Route::post('/produtos', [ProdutoController::class, 'create']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);

    //tipos de produtos
    Route::get('/tipos-produtos', [TipoProdutoController::class, 'all']);
    Route::get('/tipos-produtos/{id}', [TipoProdutoController::class, 'one']);
    Route::post('/tipos-produtos', [TipoProdutoController::class, 'create']);
    Route::put('/tipos-produtos/{id}', [TipoProdutoController::class, 'update']);

    //grupo de produtos
    Route::get('/grupos-produtos', [GrupoProdutoController::class, 'all']);
    Route::get('/grupos-produtos/{id}', [GrupoProdutoController::class, 'one']);
    Route::post('/grupos-produtos', [GrupoProdutoController::class, 'create']);
    Route::put('/grupos-produtos/{id}', [GrupoProdutoController::class, 'update']);

    //vendas
    Route::get('/vendas', [VendaController::class, 'all']);
    Route::get('/vendas/{id}', [VendaController::class, 'one']);
    Route::post('/vendas', [VendaController::class, 'create']);
    Route::put('/vendas/{id}', [VendaController::class, 'update']);


});

