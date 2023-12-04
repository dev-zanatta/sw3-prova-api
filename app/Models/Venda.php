<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable = [
        'usuario_comprou_id',
        'usuario_vendeu_id',
        'data_hora_venda',
        'valor_total',
    ];

    public function usuarioComprou()
    {
        return $this->hasOne(User::class, 'id', 'usuario_comprou_id');
    }

    public function usuarioVendeu()
    {
        return $this->hasOne(User::class, 'id', 'usuario_vendeu_id');
    }

    public function vendaItens()
    {
        return $this->hasMany(VendaItem::class, 'venda_id', 'id');
    }
}
