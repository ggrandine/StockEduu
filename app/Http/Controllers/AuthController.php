<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuario,email',
            'senha' => 'required|string|min:6',
        ]);

        $id = DB::table('usuario')->insertGetId([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha' => Hash::make($dados['senha']),
        ]);

        return response()->json([
            'mensagem' => 'Usuário cadastrado com sucesso',
            'id_usuario' => $id
        ], 201);
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $usuario = DB::table('usuario')
            ->where('email', $dados['email'])
            ->first();

        if (!$usuario || !Hash::check($dados['senha'], $usuario->senha)) {
            return response()->json([
                'mensagem' => 'Email ou senha incorretos'
            ], 401);
        }

        $token = bin2hex(random_bytes(32));

        DB::table('user_token')->insert([
            'usuario_id' => $usuario->id_usuario,
            'token' => hash('sha256', $token),
            'valido_ate' => now()->addDay(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'mensagem' => 'Login realizado com sucesso',
            'token' => $token
        ]);
    }
}
