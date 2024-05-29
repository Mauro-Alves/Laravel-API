<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Retornar a lista de usuários
     *
     * Para que a paginação funcione corretamente, é necessário incluir ?page=2 ou outro número de página válido na URL.
     *
     * Exemplo:
     *   $users = User::paginate(3);
     *
     * @return \Illuminate\Http\JsonResponse Retorna os usuários em formato JSON
     */
    public function index(): JsonResponse
    {
        // Recuperar os usuários do banco de dados
        $users = User::orderBy('id', 'DESC')->paginate(40);

        // Retornar os dados em formato de objeto e status 200
        return response()->json([
            'status' => true,
            'users' => $users,
        ], 200);
    }

    /** 
     * Recuperar os detalhes de um usuário específico.
     * 
     * @param \App\Models\User $user O id para recuperar os dados do usuário 
     * @return \Illuminate\Http\JsonResponse Retorna os dados do usuário em formato JSON
     */
    public function show(User $user): JsonResponse
    {
        // Retornar os dados em formato de objeto e status 200
        return response()->json([
            'status' => true,
            'users' => $user,
        ], 200);
    }

    public function store(UserRequest $request)
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retornar os dados em formato de objeto e status 201
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário cadastrado com sucesso!',
            ], 201);
        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::rollBack();

            // Retornar os dados em formato de objeto e status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não cadastrado!',
            ], 201);

        }
    }
}
