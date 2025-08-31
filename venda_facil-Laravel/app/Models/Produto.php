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
            'codigo_barras',
    ];
    protected $casts = [
        'preco' => 'decimal:2',
        'estoque' => 'integer',
        'ativo' => 'boolean'
    ];

    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'venda_produtos')
            ->withPivot('quantidade', 'preco_unitario', 'subtotal')
            ->withTimestamps();
    }

    public function itensVenda()
    {
        return $this->hasMany(VendaProduto::class);
    }
    // Produto.php
    public function deduzirEstoque($quantidade)
    {
        $this->estoque -= $quantidade;
        $this->save();
    }
}
