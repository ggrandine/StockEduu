<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LoginApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['mensagem' => 'Token não informado'], 401);
        }

        $registro = DB::table('user_token')
            ->where('token', hash('sha256', $token))
            ->where('valido_ate', '>', now())
            ->first();

        if (!$registro) {
            return response()->json(['mensagem' => 'Token inválido ou expirado'], 401);
        }

        $usuario = DB::table('usuario')
            ->where('id_usuario', $registro->usuario_id)
            ->first();

        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 401);
        }

        $request->attributes->set('usuario_autenticado', $usuario);

        return $next($request);
    }
}
