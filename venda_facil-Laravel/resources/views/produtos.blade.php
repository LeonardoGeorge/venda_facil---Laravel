h1>Lista de Produtos</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table border="1">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço Entrada</th>
            <th>Preço Saída</th>
            <th>Quantidade</th>
            <th>Fornecedor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produtos as $produto)
        <tr>
            <td>{{ $produto->nome_produto }}</td>
            <td>{{ $produto->categoria }}</td>
            <td>R$ {{ number_format($produto->preco_entrada, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($produto->preco_saida, 2, ',', '.') }}</td>
            <td>{{ $produto->quantidade }}</td>
            <td>{{ $produto->fornecedor }}</td>
        </tr>
        @endforeach
    </tbody>
</table>