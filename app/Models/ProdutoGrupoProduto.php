<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoGrupoProduto extends Model
{
    use HasFactory;

    protected $table = 'produtos_grupos_produtos';

    protected $fillable = [
        'produto_id',
        'grupo_produto_id',
    ];
}
