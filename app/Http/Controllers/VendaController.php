<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $venda = new Venda();
        $venda->usuario_comprou_id = $request->cliente_id;
        $venda->usuario_vendeu_id = Auth::user()->id;
        $venda->valor_total = $request->soma_valor;
        $venda->save();

        foreach ($request->produtos as $produtoVendido) {
            $vendaItem = new VendaItem;
            $vendaItem->venda_id = $venda->id;
            $vendaItem->produto_id = $produtoVendido['id'];
            $vendaItem->quantidade = $produtoVendido['quantidade'];
            $vendaItem->valor_total = $produtoVendido['valor'] * $produtoVendido['quantidade'];
            $vendaItem->save();

            $produto = Produto::find($produtoVendido['id']);
            $produto->estoque -= $produtoVendido['quantidade'];
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
