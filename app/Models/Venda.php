<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'forma_pagamento',
        'total',
        'finalizada'
    ];

    protected $casts = [
        'finalizada' => 'boolean',
        'total' => 'decimal:2'
    ];

    // Relacionamento com cliente (se existir model Cliente)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacionamento com itens da venda
    public function itens()
    {
        return $this->hasMany(VendaItem::class);
    }
}
