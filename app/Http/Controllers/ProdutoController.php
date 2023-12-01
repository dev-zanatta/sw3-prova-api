<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    //
    public function all()
    {
        $produtos = Produto::with(['tipoProduto', 'gruposProdutos'])
            ->orderBy('descricao')
            ->select('produtos.*')
            ->get();

        return $this->successResponse($produtos);
    }

    public function one($id)
    {
        $produto = Produto::with(['tipoProduto', 'gruposProdutos'])
            ->find($id);

        return $this->successResponse($produto);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only([
                'descricao',
                'valor',
                'estoque',
            ]);

            $produto = new Produto();
            $produto->fill($data);
            $produto->save();

            $produto->tipoProdutos()->attach($request->tipo_produto_id);
            $produto->grupoProdutos()->attach($request->grupos_produtos_ids);


            DB::commit();
            return $this->successResponse($produto);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->only([
                'descricao',
                'valor',
                'estoque',
                'ativo',
            ]);

            $produto = Produto::find($id);
            $produto->fill($data);
            $produto->save();

            $produto->tipoProdutos()->sync($request->tipo_produto_id);
            $produto->grupoProdutos()->sync($request->grupos_produtos_ids);

            DB::commit();
            return $this->successResponse($produto);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
