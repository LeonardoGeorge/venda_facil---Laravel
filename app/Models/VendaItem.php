<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'preco',
        'subtotal'
    ];

    protected $casts = [
        'quantidade' => 'decimal:3', // Cast para decimal com 3 casas
        'preco' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
