<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente',
        'forma_pagamento',
        'valor_total',
        'data_venda'
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
        'data_venda' => 'datetime'
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'venda_produtos')
            ->withPivot('quantidade', 'preco_unitario', 'subtotal')
            ->withTimestamps();
    }

    public function itens()
    {
        return $this->hasMany(VendaProduto::class);
    }
}
