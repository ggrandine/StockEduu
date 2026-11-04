<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    // CADASTRAR MATERIAL
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
            $material->categoria = $request->categoria;
            $material->quantidade = $request->quantidade;
            $material->unidade = $request->unidade;

            $material->save();

            return response()->json([
                'message' => 'Material cadastrado com sucesso!',
                'id' => $material->getKey(),
                'erro' => 'n'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao cadastrar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 500);
        }
    }

    // CONSULTAR MATERIAL PELO ID
    public function ver_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $material = Material::find($request->id);

        if (!$material) {
            return response()->json([
                'message' => 'Material não encontrado!',
                'erro' => 's'
            ], 404);
        }

        return response()->json([
            'material' => $material,
            'erro' => 'n'
        ], 200);
    }

    // LISTAR TODOS OS MATERIAIS
    public function listar_materiais(Request $request)
    {
        $materiais = Material::all();

        return response()->json([
            'materiais' => $materiais,
            'erro' => 'n'
        ], 200);
    }

    // LISTAR NOME E QUANTIDADE
    public function listar_materiais_simples(Request $request)
    {
        $materiais = Material::select(
            'nome',
            'quantidade'
        )->get();

        return response()->json([
            'materiais' => $materiais,
            'erro' => 'n'
        ], 200);
    }

    // ALTERAR MATERIAL
    public function alterar_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'unidade' => 'required|string|max:255',
        ]);

        try {
            $material = Material::find($request->id);

            if (!$material) {
                return response()->json([
                    'message' => 'Material não encontrado!',
                    'erro' => 's'
                ], 404);
            }

            $material->nome = $request->nome;
            $material->categoria = $request->categoria;
            $material->quantidade = $request->quantidade;
            $material->unidade = $request->unidade;

            $material->save();

            return response()->json([
                'message' => 'Material alterado com sucesso!',
                'id' => $material->getKey(),
                'erro' => 'n'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao alterar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 500);
        }
    }

    // DELETAR MATERIAL
    public function deletar_material(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        try {
            $material = Material::find($request->id);

            if (!$material) {
                return response()->json([
                    'message' => 'Material não encontrado!',
                    'erro' => 's'
                ], 404);
            }

            $id = $material->getKey();

            $material->delete();

            return response()->json([
                'message' => 'Material deletado com sucesso!',
                'id' => $id,
                'erro' => 'n'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao deletar material!',
                'erro' => 's',
                'msg_erro' => $th->getMessage()
            ], 500);
        }
    }
}
