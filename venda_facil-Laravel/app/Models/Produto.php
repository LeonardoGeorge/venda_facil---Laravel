<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
            'nome_produto',
            'categoria',
            'preco_entrada',
            'preco_saida',
            'quantidade',
            'fornecedor',
    ];
}
