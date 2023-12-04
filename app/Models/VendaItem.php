<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use HasFactory;

    protected $table = 'venda_itens';

    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'valor_total',
    ];

    public function produto()
    {
        return $this->hasOne(Produto::class, 'id', 'produto_id');
    }
}
