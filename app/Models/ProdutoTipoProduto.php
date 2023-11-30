<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoTipoProduto extends Model
{
    use HasFactory;

    protected $table = 'produtos_tipos_produtos';

    protected $fillable = [
        'produto_id',
        'tipo_produto_id',
    ];
}
