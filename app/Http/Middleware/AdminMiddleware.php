<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->attributes->get('usuario_autenticado');

        if (!$usuario) {
            return response()->json(['mensagem' => 'Não autenticado'], 401);
        }

        $admin = DB::table('admins')
            ->where('usuario_id', $usuario->id_usuario)
            ->exists();

        if (!$admin) {
            return response()->json(['mensagem' => 'Acesso negado'], 403);
        }

        return $next($request);
    }
}
