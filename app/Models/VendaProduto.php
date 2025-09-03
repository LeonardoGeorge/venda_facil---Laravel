<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaProduto extends Model
{
    use HasFactory;

    protected $table = 'venda_produtos'; // Nome da tabela

    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal'
    ];

    // Relacionamento com Venda
    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    // Relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}