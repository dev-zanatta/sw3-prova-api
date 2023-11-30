<?php

namespace App\Http\Controllers;

use App\Models\VendaItem;
use Illuminate\Http\Request;

class VendaItemController extends Controller
{
    //
    public function all()
    {
        $vendasItens = VendaItem::all();

        return $this->successResponse($vendasItens);
    }

    public function one($id)
    {
        $vendaItem = VendaItem::find($id);

        return $this->successResponse($vendaItem);
    }

    public function create(Request $request)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
        ]);

        $vendaItem = new VendaItem();
        $vendaItem->fill($data);
        $vendaItem->save();

        return $this->successResponse($vendaItem);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'descricao',
            'valor',
            'estoque',
            'ativo',
        ]);

        $vendaItem = VendaItem::find($id);
        $vendaItem->fill($data);
        $vendaItem->save();

        return $this->successResponse($vendaItem);
    }
}
