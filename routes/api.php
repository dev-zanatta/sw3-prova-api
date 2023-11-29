<?php

use App\Http\Controllers\UserController;
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
    Route::get('/usuarios', [UserController::class, 'all']);

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logout'], 200);
    })->name('logout');
});

