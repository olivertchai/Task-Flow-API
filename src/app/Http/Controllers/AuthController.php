<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // 1. Valida se mandaram email e senha
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // 2. Busca o usuário no banco e checa a senha
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => "Credenciais Inválidas"], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // 3. A mágica do Sanctum: Cria o token para este usuário!
        return response()->json([
            'message' => 'Login realizado com sucesso',
            'token' => $token
        ], 200);
    }

    /**
     * Efetua o logout do usuário, revogando o token atual.
     */
    public function logout(Request $request): JsonResponse
    {
        // Pega o token que foi usado nesta requisição específica e deleta ele do banco
        $request->user()->currentAccessToken()->delete();

        // Se você quisesse deslogar o usuário de TODOS os aparelhos (celular, pc, etc), seria assim:
        // $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso! Token revogado.'
        ], 200);
    }
}
