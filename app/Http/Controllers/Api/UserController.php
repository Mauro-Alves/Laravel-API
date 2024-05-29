<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\Constraint\JsonMatches;

class UserController extends Controller
{
    /**
     * Retornar a lista de usuários
     * 
     * Para que a paginação funcione corretamente, é necessário incluir ?page=2 ou outro número de página válido na URL.
     * 
     * Exemplo:
     *    $users = User::paginate(3);
     * 
     * @return JsonResponse Retorna os usuários
     */
    public function index(): JsonResponse
    {
        // Recuperar os usuários do banco de dados
        $users = User::orderBy('id', 'DESC')->paginate(40);

        // Retornar os dados em formato de objeto e status 200
        return response()->json([
    'status' => true,
    'users' => $users
    ], 200);
    }

    /**
     *  R4ecuperar os detalhes de um usuário específico.
     * 
     * @paran \App\Models\User $user O id para recuperar os dados do usuário
     * @return \Illuminate\Http\JsonResponse Retorna os dados do usuário em formato JSON
     */

    public function show(User $user) : JsonResponse
    {
        // Retornar os dados em formato de objeto e status 200
        return response()->json([
        'status' => true,
        'users' => $user
        ], 200);
    }
}
