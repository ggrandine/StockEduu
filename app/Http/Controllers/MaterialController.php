<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function salvar_material(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'unidade' => 'required|string|max:255',
        ]);

        try {
            $material = new Material();
            $material->nome = $request->nome;
            $material->quantidade = $request->quantidade;
            $material->unidade = $request->unidade;
            $material->categoria = $request->categoria;
            $material->save();

            return response()->json([
                'message' => 'Material cadastrado com sucesso!',
                'erro' => 'n'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao cadastrar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 200);
        }
    }


    public function ver_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $material = Material::find($request->id);

        if ($material) {
            return response()->json([
                'material' => $material,
                'erro' => 'n'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Material não encontrado!',
                'erro' => 's'
            ], 200);
        }
    }


    public function listar_materiais(Request $request)
    {
        $materiais = Material::all();

        return response()->json([
            'materiais' => $materiais
        ], 200);
    }


    public function listar_materiais_simples(Request $request)
    {
        $materiais = Material::select('nome', 'quantidade')->get();

        return response()->json([
            'materiais' => $materiais
        ], 200);
    }


    public function alterar_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|',
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'unidade' => 'required|string|max:255',
            
        ]);

        try {
            $material = Material::find($request->id);

            if ($material) {
                $material->id = $request->id;
                $material->nome = $request->nome;
                $material->categoria = $request->categoria;
                $material->quantidade = $request->quantidade;
                $material->unidade = $request->unidade;
                
                $material->save();

                return response()->json([
                    'message' => 'Material alterado com sucesso!',
                    'erro' => 'n'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Material não encontrado!',
                    'erro' => 's'
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao alterar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 200);
        }
    }


    public function deletar_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:material,id',
        ]);

        try {
            $material = Material::find($request->id);
            $material->delete();

            return response()->json([
                'message' => 'Material deletado com sucesso!',
                'erro' => 'n'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao deletar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 200);
        }
    }
}