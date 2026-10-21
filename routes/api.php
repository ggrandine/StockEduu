<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;


Route::post('/salvar_material', [MaterialController::class, 'salvar_material']);
Route::get('/ver_material', [MaterialController::class, 'ver_material']);
Route::get('/listar_materiais', [MaterialController::class, 'listar_materiais']);
Route::get('/listar_materiais_simples', [MaterialController::class, 'listar_materiais_simples']);
Route::put('/alterar_material', [MaterialController::class, 'alterar_material']);
Route::delete('/deletar_material', [MaterialController::class, 'deletar_material']);
