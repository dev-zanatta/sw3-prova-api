<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'descricao',
        'valor',
        'estoque',
        'ativo',
    ];

    // attach e sync
    public function tipoProdutos()
    {
        return $this->belongsToMany(TipoProduto::class, 'produtos_tipos_produtos', 'produto_id', 'tipo_produto_id');
    }

    // attach e sync
    public function grupoProdutos()
    {
        return $this->belongsToMany(GrupoProduto::class, 'produtos_grupos_produtos', 'produto_id', 'grupo_produto_id');
    }

    // with
    public function tipoProduto()
    {
        return $this->hasOneThrough(TipoProduto::class, ProdutoTipoProduto::class, 'produto_id', 'id', 'id', 'tipo_produto_id');
    }

    // with
    public function gruposProdutos()
    {
        return $this->hasManyThrough(GrupoProduto::class, ProdutoGrupoProduto::class, 'produto_id', 'id', 'id', 'grupo_produto_id');
    }

}
