<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendaController extends Controller
{
    //
    public function all()
    {
        $vendas = Venda::with([
            'usuarioComprou:id,name',
            'usuarioVendeu:id,name',
            'vendaItens',
            'vendaItens.produto:id,descricao',
        ])->get();

        return $this->successResponse($vendas);
    }

    public function one($id)
    {
        $venda = Venda::with([
            'usuarioComprou:id,name',
            'usuarioVendeu:id,name',
            'vendaItens',
            'vendaItens.produto:id,descricao',
        ])->first();

        return $this->successResponse($venda);
    }

    public function create(Request $request)
    {
        foreach ($request->produtos as $produtoVenda) {
            $produto = Produto::find($produtoVenda['id']);
            if ($produto->estoque < $produtoVenda['quantidade']) {
                return $this->errorResponse('Produto ' . $produto->descricao . ' não possui estoque suficiente', 200);
            }
        }

        $valor_total = 0;

        foreach ($request->produtos as $produto) {
            $valor_total += $produto['valor'] * $produto['quantidade'];
        }

        $venda = new Venda();
        $venda->usuario_comprou_id = $request->cliente_id;
        $venda->usuario_vendeu_id = Auth::user()->id;
        $venda->valor_total = $valor_total;
        $venda->save();

        foreach ($request->produtos as $produto) {
            $vendaItem = new VendaItem;
            $vendaItem->venda_id = $venda->id;
            $vendaItem->produto_id = $produto['id'];
            $vendaItem->quantidade = $produto['quantidade'];
            $vendaItem->valor_total = $produto['valor'] * $produto['quantidade'];
            $vendaItem->save();
        }

        foreach ($request->produtos as $produto) {
            $produto = Produto::find($produto['id']);
            $produto->estoque -= $produto['quantidade'];
            $produto->save();
        }



        return $this->successResponse($venda);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
            'ativo',
        ]);

        $venda = Venda::find($id);
        $venda->fill($data);
        $venda->save();

        return $this->successResponse($venda);
    }
}
