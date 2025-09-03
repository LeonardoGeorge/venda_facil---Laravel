<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>VendaFácil - Clientes</title>
    
    <style>
        /* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #020202;
  color: #333;
}

/* ===== HEADER ===== */
header {
  background-color: #1a1717;
  color: white;
  padding: 20px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

header h1 {
  font-size: 24px;
  color: #7ac943;
}

nav {
  margin-top: 10px;
}

nav a {
  color: white;
  text-decoration: none;
  margin-left: 20px;
  font-weight: bold;
  transition: color 0.3s ease;
}

nav a:hover {
  color: #7ac943;
}

/* ===== MAIN CONTENT ===== */
main {
  max-width: 600px;
  margin: 40px auto;
  background: #ffffff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

 section h2 {
          margin-bottom: 20px;
          color: #4d7c2b;
          border-bottom: 2px solid #7ac943;
          padding-bottom: 10px;
        }


/* ===== FORM ===== */
form label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
}

form input {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 15px;
}

form button {
          background-color: #7ac943;
          color: white;
          border: none;
          padding: 12px 20px;
          font-size: 16px;
          cursor: pointer;
          border-radius: 4px;
          transition: background 0.3s ease;
          width: 100%;
        }

        form button:hover {
          background-color: #3b691a;
        }

small {
  display: block;
  margin-top: -10px;
  margin-bottom: 15px;
  font-size: 12px;
  color: #777;
}

/* ===== FOOTER ===== */
.footer {
  text-align: center;
  padding: 15px;
  background-color: #eee;
  margin-top: 40px;
  color: #555;
}


    </style>


</head>
<body>
@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
<div class="container">
    <h2 class="page-title">Editar Produto</h2>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Isso é fundamental para o Laravel aceitar o método correto --}}

        <label for="nome_produto">Nome do Produto</label>
        <input type="text" name="nome_produto" value="{{ $produto->nome_produto }}" required>

        <label for="categoria">Categoria</label>
        <input type="text" name="categoria" value="{{ $produto->categoria }}" required>

        <label for="preco_entrada">Preço Entrada</label>
        <input type="number" name="preco_entrada" step="0.01" value="{{ $produto->preco_entrada }}" required>

        <label for="preco_saida">Preço Saída</label>
        <input type="number" name="preco_saida" step="0.01" value="{{ $produto->preco_saida }}" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" value="{{ $produto->quantidade }}" required>

        <label for="fornecedor">Fornecedor</label>
        <input type="text" name="fornecedor" value="{{ $produto->fornecedor }}" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const precoEntrada = document.querySelector("input[name='preco_entrada']");
    const precoSaida = document.querySelector("input[name='preco_saida']");

    // Validação simples
    form.addEventListener("submit", (e) => {
        if (parseFloat(precoEntrada.value) >= parseFloat(precoSaida.value)) {
            e.preventDefault();
            alert("O preço de saída deve ser maior que o preço de entrada.");
        }
    });

    // Formatação de valores monetários
    function formatMoney(input) {
        input.addEventListener("input", () => {
            let val = input.value.replace(/\D/g, "");
            val = (val / 100).toFixed(2);
            input.value = val;
        });
    }

    formatMoney(precoEntrada);
    formatMoney(precoSaida);
});
</script>

</body>
</html> 
