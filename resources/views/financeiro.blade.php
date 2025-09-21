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
    <div class="logo"><a href="http://localhost:8000/" style="color: white; text-decoration: none;">Venda<span>FACIL</span></a></div>
    <nav>
        <ul class="menu">
            <li><a href="http://localhost:8000/venda">Vendas</a></li>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
            <li><a href="http://localhost:8000/produtos">Produtos</a></li>
            <li><a href="http://localhost:8000/financeiro">Financeiro</a></li>
            
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
         <!-- Preenchido via backend ou JS -->
        <tbody id="tabelaFinanceiro">
            @foreach($vendas as $venda)
            <tr>
                <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</td>
                <td>{{ $venda->name_cliente ?? 'Cliente não informado' }}</td>
                <td>{{ ucfirst($venda->forma_pagamento) }}</td>
                <td>R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                <td>Concluído</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="resumo">
        <div class="resumo-item">
            Período Selecionado <span id="totalPeriodo">R$ 0,00</span>
        </div>
        <div class="resumo-item">
            Média por Dia <span id="mediaDiaria">R$ 0,00</span>
        </div>
        <div class="resumo-item">
            Total de Vendas <span id="totalVendas">0</span>
        </div>
    </div>

<script>
function filtrarFinanceiro() {
    const inicio = document.getElementById('dataInicio').value;
    const fim = document.getElementById('dataFim').value;
    const cliente = document.getElementById('filtroCliente').value;

    const url = `/api/financeiro?inicio=${inicio}&fim=${fim}&cliente=${cliente}`;

    fetch(url)
        .then(response => response.ok ? response.json() : [])
        .then(data => {
            // fallback caso a API não retorne nada
            if (!Array.isArray(data)) {
                data = [];
            }

            const tbody = document.getElementById('tabelaFinanceiro');
            tbody.innerHTML = '';
            
            let totalPeriodo = 0;
            let totalVendas = 0;
            
            // Calcular totais baseados no período filtrado
            data.forEach(venda => {
                const valorVenda = parseFloat(venda.valor_total);
                totalPeriodo += valorVenda;
                totalVendas++;
                
                tbody.innerHTML += `
                <tr>
                    <td>${new Date(venda.data_venda).toLocaleDateString('pt-BR')}</td>
                    <td>${venda.name_cliente ?? 'Cliente não informado'}</td> <!-- Alterado aqui -->
                    <td>${venda.forma_pagamento ?? '-'}</td>
                    <td>R$ ${valorVenda.toFixed(2).replace('.', ',')}</td>
                    <td>Concluído</td>
                </tr>
            `;
            });
            
            // Calcular média diária
            let mediaDiaria = 0;
            if (inicio && fim && data.length > 0) {
                const dataInicio = new Date(inicio);
                const dataFim = new Date(fim);
                const diffTime = Math.abs(dataFim - dataInicio);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 para incluir ambos os dias
                mediaDiaria = totalPeriodo / diffDays;
            }

            // Atualizar os totais no resumo
            document.getElementById('totalPeriodo').textContent = 
                'R$ ' + totalPeriodo.toFixed(2).replace('.', ',');
            document.getElementById('mediaDiaria').textContent = 
                'R$ ' + mediaDiaria.toFixed(2).replace('.', ',');
            document.getElementById('totalVendas').textContent = totalVendas;
        })
         .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        // ... código existente
    })
    .catch(error => {
        console.error('Erro ao filtrar dados:', error);
        alert('Erro ao carregar dados financeiros. Verifique o console para mais detalhes.');
    });
}

// Inicializar campos de data com valores padrão
window.onload = function() {
    const hoje = new Date();
    const seteDiasAtras = new Date();
    seteDiasAtras.setDate(hoje.getDate() - 7);
    
    document.getElementById('dataInicio').value = formatDate(seteDiasAtras);
    document.getElementById('dataFim').value = formatDate(hoje);
    
    // Carregar dados iniciais
    filtrarFinanceiro();
};

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

</script>


</body>
</html>