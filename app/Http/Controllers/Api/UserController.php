<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
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

    /**
     * Cria novo usuário com os dados fornecidos na requisição.
     * 
     * @param  \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuário a ser criado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
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
            ], 400);
        }
    }

    /**
     * Atualizar os dados de um usuário existente com base nos dados fornecidos na requisição.
     * 
     * @param  \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuário a ser atualizado.
     * @param  \App\Models\User  $user O usuário a ser atualizado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retornar os dados em formato de objeto e status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário editado com sucesso!',
            ], 200);

        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::rollBack();

            // Retornar os dados em formato de objeto e status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não editado!',
            ], 400);

        }
    }

    /**
     * Atualizar as senha de um usuário existente com base nos dados fornecidos na requisição.
     * 
     * @param  \App\Http\Requests\UserPasswordRequest  $request O objeto de requisição contendo os dados do usuário a ser atualizado.
     * @param  \App\Models\User  $user O usuário a ser atualizado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UserPasswordRequest $request, User $user): JsonResponse
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

            $user->update([
                'password' => $request->password,
            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retornar os dados em formato de objeto e status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Senha editada com sucesso!',
            ], 200);

        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::rollBack();

            // Retornar os dados em formato de objeto e status 400
            return response()->json([
                'status' => false,
                'message' => 'Senha não editada!',
            ], 400);

        }
    }

    /**
     * Excluir usuário no banco de dados.
     * 
     * @param  \App\Models\User  $user O usuário a ser excluído.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try{

            // Excluir o registro do banco de dados
            $user->delete();

            // Retornar os dados em formato de objeto e status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuário apagado com sucesso!',
            ], 200);


        } catch (Exception $e){
            // Retornar os dados em formato de objeto e status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuário não apagado!',
            ], 400);
        }
    }
}
