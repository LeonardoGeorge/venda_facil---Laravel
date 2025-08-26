<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Financeiro - VendaFácil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #000;
            color: white;
        }

        .top-bar {
            background: #111;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .logo span {
            background: #7ac943;
            color: #181818;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 4px;
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .menu li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .menu li a:hover {
            color: #7ac943;
        }

        .financeiro-container {
            padding: 20px 40px;
        }

        h1 {
            text-align: center;
            color: #7ac943;
        }

        .filtros {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filtros input,
        .filtros select {
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            min-width: 200px;
        }

        .filtros button {
            background-color: #7ac943;
            color: black;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1c1c1c;
            color: white;
            border-radius: 6px;
            overflow: hidden;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        table th {
            background-color: #333;
            color: #7ac943;
        }

        .resumo {
            margin-top: 20px;
            background: #111;
            padding: 20px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            color: white;
        }

        .resumo-item {
            font-size: 18px;
        }

        .resumo-item span {
            display: block;
            font-size: 24px;
            color: #7ac943;
        }

    </style>
</head>
<body>

<header class="top-bar">
    <div class="logo"><a href="http://localhost:8000/" style="color: white;">Venda<span>FACIL</span></a></div>
    <nav>
        <ul class="menu">
            <li><a href="http://localhost:8000/venda">Vendas</a></li>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
            <li><a href="http://localhost:8000/produtos">Produtos</a></li>
            <li><a href="http://localhost:8000/financeiro">Financeiro</a></li>
            <li><a href="http://localhost:8000/estoque">Estoque</a></li>
        </ul>
    </nav>
</header>

<div class="financeiro-container">
    <h1>Controle Financeiro</h1>

    <div class="filtros">
        <input type="date" id="dataInicio">
        <input type="date" id="dataFim">
        <input type="text" placeholder="Buscar por cliente..." id="filtroCliente">
        <button onclick="filtrarFinanceiro()">Filtrar</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Valor Pago</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="tabelaFinanceiro">
            <!-- Preenchido via backend ou JS -->
            <tr>
                <td>2025-07-31</td>
                <td>João da Silva</td>
                <td>Pix</td>
                <td>R$ 250,00</td>
                <td>Concluído</td>
            </tr>
        </tbody>
    </table>
    <div class="resumo">
        <tbody id="tabelaFinanceiro">
            @foreach($vendas as $venda)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</td>
                    <td>{{ $venda->cliente }}</td>
                    <td>{{ ucfirst($venda->forma_pagamento) }}</td>
                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                    <td>Concluído</td>
                </tr>
            @endforeach
        </tbody>
        <div class="resumo-item">
            Hoje <span>R$ {{ number_format($totalDiario, 2, ',', '.') }}</span>
        </div>
        <div class="resumo-item">
            Semana <span>R$ {{ number_format($totalSemanal, 2, ',', '.') }}</span>
        </div>
        <div class="resumo-item">
            Mês <span>R$ {{ number_format($totalMensal, 2, ',', '.') }}</span>
        </div>
    </div>

<script>
function filtrarFinanceiro() {
    const inicio = document.getElementById('dataInicio').value;
    const fim = document.getElementById('dataFim').value;
    const cliente = document.getElementById('filtroCliente').value;

    console.log("Filtrar por:", { inicio, fim, cliente });

    // Aqui você faria a chamada para seu backend Laravel (ex: /api/financeiro?inicio=...&fim=...)
}
</script>

</body>
</html>
