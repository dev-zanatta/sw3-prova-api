<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    use HasFactory;

    protected $table = 'tipos_produtos';

    protected $fillable = [
        'descricao',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_tipo_produto', 'tipo_produto_id', 'produto_id');
    }
}
