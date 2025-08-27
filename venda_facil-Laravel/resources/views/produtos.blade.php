@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <h2 class="page-title">Lista de Produtos</h2>

    <input type="text" id="searchInput" placeholder="Pesquisar produto..." class="search-input">

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço Entrada</th>
                <th>Preço Saída</th>
                <th>Quantidade</th>
                <th>Fornecedor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->nome_produto }}</td>
                <td>{{ $produto->categoria }}</td>
                <td>R$ {{ number_format($produto->preco_entrada, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($produto->preco_saida, 2, ',', '.') }}</td>
                <td>{{ $produto->quantidade }}</td>
                <td>{{ $produto->fornecedor }}</td>
                <td>
                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn-edit">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("tbody tr");

    searchInput.addEventListener("input", () => {
        const term = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
            row.style.display = name.includes(term) ? "" : "none";
        });
    });
});
</script>
@endsection
