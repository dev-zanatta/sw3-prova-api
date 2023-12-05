<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RelatorioController extends Controller
{
    public function melhorVendedor()
    {
        $vendedor_usuario_id = Venda::select('usuario_vendeu_id')
            ->selectRaw('COUNT(*) as total_vendas')
            ->groupBy('usuario_vendeu_id')
            ->orderByDesc('total_vendas')
            ->first();

        $vendas = Venda::leftJoin('users as usuarioComprou', 'usuarioComprou.id', '=', 'vendas.usuario_comprou_id')
            ->leftJoin('users as usuarioVendeu', 'usuarioVendeu.id', '=', 'vendas.usuario_vendeu_id')
            ->leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->leftJoin('produtos', 'produtos.id', '=', 'venda_itens.produto_id')
            ->select('usuarioVendeu.name as nome_vendedor', 'usuarioComprou.name as nome_cliente', 'vendas.created_at as data_venda', 'vendas.valor_total', 'produtos.descricao as nome_produto', 'venda_itens.quantidade')
            ->where('usuario_vendeu_id', $vendedor_usuario_id->usuario_vendeu_id)
            ->get();

        return $this->successResponse($vendas);
    }

    public function melhorCliente()
    {
        $cliente_usuario_id = Venda::select('usuario_comprou_id')
            ->selectRaw('COUNT(*) as total_vendas')
            ->groupBy('usuario_comprou_id')
            ->orderByDesc('total_vendas')
            ->first();

        $vendas = Venda::leftJoin('users as usuarioComprou', 'usuarioComprou.id', '=', 'vendas.usuario_comprou_id')
            ->leftJoin('users as usuarioVendeu', 'usuarioVendeu.id', '=', 'vendas.usuario_vendeu_id')
            ->leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->leftJoin('produtos', 'produtos.id', '=', 'venda_itens.produto_id')
            ->select('usuarioVendeu.name as nome_vendedor', 'usuarioComprou.name as nome_cliente', 'vendas.created_at as data_venda', 'vendas.valor_total', 'produtos.descricao as nome_produto', 'venda_itens.quantidade')
            ->where('usuario_comprou_id', $cliente_usuario_id->usuario_comprou_id)
            ->get();

        return $this->successResponse($vendas);
    }

    public function maisVendido()
    {
        $produto_id = Venda::leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->select('produto_id')
            ->selectRaw('SUM(venda_itens.quantidade) as total_vendido')
            ->groupBy('produto_id')
            ->orderByDesc('total_vendido')
            ->first();

        $vendas = Venda::leftJoin('users as usuarioComprou', 'usuarioComprou.id', '=', 'vendas.usuario_comprou_id')
            ->leftJoin('users as usuarioVendeu', 'usuarioVendeu.id', '=', 'vendas.usuario_vendeu_id')
            ->leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->leftJoin('produtos', 'produtos.id', '=', 'venda_itens.produto_id')
            ->select('usuarioVendeu.name as nome_vendedor', 'usuarioComprou.name as nome_cliente', 'vendas.created_at as data_venda', 'vendas.valor_total', 'produtos.descricao as nome_produto', 'venda_itens.quantidade')
            ->where('produto_id', $produto_id->produto_id)
            ->get();

        return $this->successResponse($vendas);
    }

    public function menosVendido()
    {
        $produto_id = Venda::leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->select('produto_id')
            ->selectRaw('SUM(venda_itens.quantidade) as total_vendido')
            ->groupBy('produto_id')
            ->orderBy('total_vendido')
            ->first();

        $vendas = Venda::leftJoin('users as usuarioComprou', 'usuarioComprou.id', '=', 'vendas.usuario_comprou_id')
            ->leftJoin('users as usuarioVendeu', 'usuarioVendeu.id', '=', 'vendas.usuario_vendeu_id')
            ->leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->leftJoin('produtos', 'produtos.id', '=', 'venda_itens.produto_id')
            ->select('usuarioVendeu.name as nome_vendedor', 'usuarioComprou.name as nome_cliente', 'vendas.created_at as data_venda', 'vendas.valor_total', 'produtos.descricao as nome_produto', 'venda_itens.quantidade')
            ->where('produto_id', $produto_id->produto_id)
            ->get();

        return $this->successResponse($vendas);
    }

    public function valorVendas()
    {
        $media_valor_vendas = Venda::leftJoin('venda_itens', 'venda_itens.venda_id', '=', 'vendas.id')
            ->leftJoin('produtos', 'produtos.id', '=', 'venda_itens.produto_id')
            ->select('produtos.descricao as produto', 'produtos.valor as valor_produto')
            ->selectRaw('SUM(venda_itens.valor_total) as total_vendido')
            ->selectRaw('AVG(venda_itens.valor_total) as media_vendido')
            ->groupBy('produto_id', 'produtos.descricao', 'produtos.valor')
            ->get();

        return $this->successResponse($media_valor_vendas);
    }
}
