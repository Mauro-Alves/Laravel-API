<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    /**
     * Realiza a autenticação do usuário.
     *
     * Este método tenta autenticar o usuário com as credenciais fornecidas.
     * Se a autenticação for bem-sucedida, retorna o usuário autenticado juntamente com um token de acesso.
     * Se a autenticação falhar, retorna uma mensagem de erro.
     *
     * @param \Illuminate\Http\Request $request O objeto de requisição HTTP contendo as credenciais do usuário (email e senha).
     * @return \Illuminate\Http\JsonResponse Uma resposta JSON contendo o usuário autenticado e um token de acesso se a autenticação for bem-sucedida, ou uma mensagem de erro se a autenticação falhar.
     */
    public function login(Request $request) : JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            // Recuperar os dados do usuário logado
            $user = Auth::user();

            // Criar o token para o usuário logado
            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,                
            ], 201);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta.'
            ], 404);
        }
    }
}
