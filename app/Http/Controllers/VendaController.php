<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendaController extends Controller
{
    //
    public function all()
    {
        $vendas = Venda::all();

        return $this->successResponse($vendas);
    }

    public function one($id)
    {
        $venda = Venda::find($id);

        return $this->successResponse($venda);
    }

    public function create(Request $request)
    {
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
