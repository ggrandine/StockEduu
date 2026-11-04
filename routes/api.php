
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\LoginApiMiddleware;
use App\Http\Middleware\AdminMiddleware;

Route::post('/salvar_material', [MaterialController::class, 'salvar_material']);
Route::get('/ver_material', [MaterialController::class, 'ver_material']);
Route::get('/listar_materiais', [MaterialController::class, 'listar_materiais']);
Route::get('/listar_materiais_simples', [MaterialController::class, 'listar_materiais_simples']);

Route::put('/alterar_material', [MaterialController::class, 'alterar_material']);
Route::delete('/deletar_material', [MaterialController::class, 'deletar_material']);

Route::post('/cadastrar', [AuthController::class, 'cadastrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin', function () {
    return response()->json(['mensagem' => 'Acesso autorizado']);
})->middleware([LoginApiMiddleware::class, AdminMiddleware::class]);

Route::post('/logout', [LogoutController::class, 'logout'])->middleware(LoginApiMiddleware::class);
