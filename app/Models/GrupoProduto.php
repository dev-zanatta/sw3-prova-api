<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoProduto extends Model
{
    use HasFactory;

    protected $table = 'grupos_produtos';

    protected $fillable = [
        'descricao',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_grupo_produto', 'grupo_produto_id', 'produto_id');
    }
}
