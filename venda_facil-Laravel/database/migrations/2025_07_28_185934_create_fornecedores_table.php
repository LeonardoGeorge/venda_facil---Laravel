<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome_razao_social', 255);
            $table->string('cnpj', 18)->unique(); // Formatado: 00.000.000/0000-00
            $table->string('telefone', 20); // Formatado: (00) 00000-0000
            $table->string('email', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->char('estado', 2); // Sigla do estado (SP, RJ, etc.)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
};
