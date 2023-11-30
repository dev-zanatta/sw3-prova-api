<?php

namespace App\Http\Controllers;

use App\Models\TipoProduto;
use Illuminate\Http\Request;

class TipoProdutoController extends Controller
{
    //
    public function all()
    {
        $tiposProdutos = TipoProduto::all();

        return $this->successResponse($tiposProdutos);
    }

    public function one($id)
    {
        $tipoProduto = TipoProduto::find($id);

        return $this->successResponse($tipoProduto);
    }

    public function create(Request $request)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
        ]);

        $tipoProduto = new TipoProduto();
        $tipoProduto->fill($data);
        $tipoProduto->save();

        return $this->successResponse($tipoProduto);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
            'ativo',
        ]);

        $tipoProduto = TipoProduto::find($id);
        $tipoProduto->fill($data);
        $tipoProduto->save();

        return $this->successResponse($tipoProduto);
    }
}
