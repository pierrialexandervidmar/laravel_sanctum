<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar Requisição
        $request->validate([
            'email' => ['required', 'string', 'email:rfc'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Login
        $email = $request->input('email');
        $password = $request->input('password');

        // Verificar se o usuário existe e se a senha está correta
        $attempt = auth()->attempt([
            'email' => $email,
            'password' => $password,
        ]);

        if (!$attempt)
        {
            return ApiResponse::unauthorized();
        }

        // Gera um token JWT para o usuário
        $user = auth()->user();

        // Dados para o payload do JWT
        $payload = [
            'iss' => "SistemaSeguroAPISanctum", // Emissor do token
            'sub' => $user->id, // ID do usuário
            'iat' => time(), // Hora de emissão
            'exp' => time() + (60 * 60), // Expiração (1 hora)
        ];

        // Chave secreta (deixe isso no .env)
        $key = env('JWT_SECRET');

        $jwt = JWT::encode($payload, $key, 'HS256');

        //$token = $user->createToken('authToken')->plainTextToken;

        return ApiResponse::success([
            'token' => $jwt
        ]);
    }
}
