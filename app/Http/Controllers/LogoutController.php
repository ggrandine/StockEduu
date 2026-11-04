<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        DB::table('user_token')
            ->where('token', hash('sha256', $token))
            ->delete();

        return response()->json([
            'mensagem' => 'Logout realizado com sucesso'
        ]);
    }
}
