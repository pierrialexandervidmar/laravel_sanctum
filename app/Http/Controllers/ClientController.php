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
        //
    }

    /**
     * Mostrar os dados de um único cliente
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Atualizar os dados de um único cliente
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove um único cliente
     */
    public function destroy(string $id)
    {
        //
    }
}
