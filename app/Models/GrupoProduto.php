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
}
