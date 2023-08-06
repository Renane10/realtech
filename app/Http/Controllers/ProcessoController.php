<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProcessoController extends Controller
{
    public function index()
    {
        // Coloque aqui a lógica para obter os dados dos processos e passá-los para a view
    }

    public function store(Request $request)
    {
        // Adicione as validações de acordo com os campos da tabela de processos
        $validator = Validator::make($request->all(), [
            // Defina as validações para cada campo
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        Processo::create($request->all());

        return response()->json(['success' => true, 'message' => 'Processo criado com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        $processo = Processo::findOrFail($id);

        // Adicione as validações de acordo com os campos da tabela de processos
        $validator = Validator::make($request->all(), [
            // Defina as validações para cada campo
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $processo->update($request->all());

        return response()->json(['success' => true, 'message' => 'Processo atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $processo = Processo::findOrFail($id);

        $processo->delete();

        return response()->json(['success' => true, 'message' => 'Processo excluído com sucesso!']);
    }
}
