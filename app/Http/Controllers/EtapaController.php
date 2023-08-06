<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtapaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'icone' => 'required|string',
            'cor' => 'required|string',
            // Adicione as validações para outros campos aqui...
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        Etapa::create($request->all());

        return response()->json(['success' => true, 'message' => 'Etapa criada com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        $etapa = Etapa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'icone' => 'required|string',
            'cor' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $etapa->update($request->all());

        return response()->json(['success' => true, 'message' => 'Etapa atualizada com sucesso!']);
    }

    public function destroy($id)
    {
        $etapa = Etapa::findOrFail($id);

        $etapa->delete();

        return response()->json(['success' => true, 'message' => 'Etapa excluída com sucesso!']);
    }

}
