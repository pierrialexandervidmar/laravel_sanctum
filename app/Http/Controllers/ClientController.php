<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Listar todos os clientes da base de dados
     */
    public function index(Request $request)
    {

        $perPage = $request->query('per_page', 15);

        if ($perPage < 1) {
            $perPage = 15;
        }

        $clients = Client::paginate($perPage);

        // Retorna a resposta JSON com os dados de paginação e os recursos formatados
        return response()->json([
            'data' => ClientResource::collection($clients), // Dados dos clientes
            'pagination' => [
                'current_page' => $clients->currentPage(),
                'total_pages' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total_items' => $clients->total(),
            ]
        ], 200);
    }

    /**
     * Adicionar um novo cliente
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'unique:clients,email'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
        ]);

        $client = Client::create($validatedData);

        return response()->json([
            'message' => 'Cliente adicionado com sucesso',
            'data' => new ClientResource($client)
        ], 201);
    }

    /**
     * Mostrar os dados de um único cliente
     */
    public function show(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
               'message' => 'Cliente não encontrado'
            ], 404);
        }

        return response()->json([
            'data' => new ClientResource($client)
        ], 200);
    }

    /**
     * Atualizar os dados de um único cliente
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email:rfc'],
            'phone' => ['string', 'min:10', 'max:15'],
        ]);

        $client = Client::find($id);

        if (!$client) {
            return response()->json([
               'message' => 'Cliente não encontrado'
            ], 404);
        }

        $client->update($validatedData);

        return response()->json([
            'message' => 'Cliente atualizado com sucesso',
            'data' => new ClientResource($client)
        ], 200);        
    }

    /**
     * Remove um único cliente
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
               'message' => 'Cliente não encontrado'
            ], 404);
        }

        $client->delete();

        return response()->json([
           'message' => 'Cliente excluído com sucesso'
        ], 204);
    }
}
