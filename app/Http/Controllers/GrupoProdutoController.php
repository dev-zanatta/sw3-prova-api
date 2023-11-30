<?php

namespace App\Http\Controllers;

use App\Models\GrupoProduto;
use Illuminate\Http\Request;

class GrupoProdutoController extends Controller
{
    //
    public function all()
    {
        $gruposProdutos = GrupoProduto::all();

        return $this->successResponse($gruposProdutos);
    }

    public function one($id)
    {
        $grupoProduto = GrupoProduto::find($id);

        return $this->successResponse($grupoProduto);
    }

    public function create(Request $request)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
        ]);

        $grupoProduto = new GrupoProduto();
        $grupoProduto->fill($data);
        $grupoProduto->save();

        return $this->successResponse($grupoProduto);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
            'ativo',
        ]);

        $grupoProduto = GrupoProduto::find($id);
        $grupoProduto->fill($data);
        $grupoProduto->save();

        return $this->successResponse($grupoProduto);
    }
}
