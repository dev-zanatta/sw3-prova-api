<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

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
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
        ]);

        $venda = new Venda();
        $venda->fill($data);
        $venda->save();

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
