<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('venda_produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->decimal('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2); // Coluna normal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venda_produtos');
    }
};
