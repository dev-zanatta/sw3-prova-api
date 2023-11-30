<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    //
    public function all()
    {
        $produtos = Produto::all();

        return $this->successResponse($produtos);
    }

    public function one($id)
    {
        $produto = Produto::find($id);

        return $this->successResponse($produto);
    }

    public function create(Request $request)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
        ]);

        $produto = new Produto();
        $produto->fill($data);
        $produto->save();

        return $this->successResponse($produto);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
            'ativo',
        ]);

        $produto = Produto::find($id);
        $produto->fill($data);
        $produto->save();

        return $this->successResponse($produto);
    }
}
