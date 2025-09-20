<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Vendas - Supermercado</title>
    <style>
    body { 
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f7f9;
        color: #333;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .top-bar {
        background: #2c3e50;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 40px;
        flex-wrap: wrap;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    .logo span {
        background: #27ae60;
        color: white;
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
        transition: color 0.3s;
    }

    .menu li a:hover {
        color: #27ae60;
    }

    .auth-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-outline {
        background: transparent;
        color: white;
        border: 1px solid white;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .btn-outline:hover {
        background: white;
        color: #2c3e50;
    }

    .btn-solid {
        background: #27ae60;
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 4px;
        transition: background 0.3s;
    }

    .btn-solid:hover {
        background: #219653;
    }

    .pdv-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-title {
        text-align: center;
        background-color: #2c3e50;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .pdv-content {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .left-panel, .right-panel {
        background: white;
        border-radius: 8px;
        padding: 20px;
        flex: 1;
        min-width: 300px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .scanner-container {
        position: relative;
        width: 100%;
        height: 150px;
        border: 2px dashed #ccc;
        overflow: hidden;
        margin: 10px 0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
    }

    .scanner-container video {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    .scanner-container canvas {
        width: 100% !important;
        height: 100% !important;
        position: absolute;
        top: 0;
        left: 0;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .input-group input, .input-group select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: border 0.3s;
    }

    .input-group input:focus, .input-group select:focus {
        border-color: #27ae60;
        outline: none;
    }

    .btn-venda {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        background-color: #27ae60;
        color: white;
        font-weight: bold;
        border: none;
        margin-top: 15px;
        cursor: pointer;
        border-radius: 4px;
        transition: background 0.3s;
    }

    .btn-venda:hover {
        background-color: #219653;
    }

    .nota {
        position: relative;
    }

    .nota pre {
        background: #f9f9f9;
        padding: 15px;
        font-family: monospace;
        border: 1px solid #ddd;
        height: 300px;
        overflow-y: auto;
        white-space: pre-wrap;
        border-radius: 8px;
        line-height: 1.5;
    }

    .print-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #3498db;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.3s;
        z-index: 10;
    }

    .print-icon:hover {
        background: #2980b9;
    }

    .totais {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        gap: 10px;
    }

    .volumes input {
        width: 100px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .total-venda {
        text-align: right;
    }

    .total-venda label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .total-destaque {
        font-size: 24px;
        font-weight: bold;
        color: #e74c3c;
    }

    .pay {
        margin-top: 20px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .total-pagamento {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .valor-pago, .troco {
        flex: 1;
    }
    
    #resultadoCliente {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        width: calc(100% - 2px);
        max-height: 150px;
        overflow-y: auto;
        z-index: 100;
        border-radius: 0 0 4px 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    #resultadoCliente div {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    
    #resultadoCliente div:hover {
        background: #f0f0f0;
    }
    
    .scanner-btn {
        background: #3498db;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s;
    }
    
    .scanner-btn:hover {
        background: #2980b9;
    }
    </style>
</head>

<body>
    <header class="top-bar">
        <div class="logo"><a href="http://localhost:8000/">Venda<span>FACIL</span></a></div>
        <nav>
            <ul class="menu">
                <a href="http://localhost:8000/">Início</a>
                <a href="http://localhost:8000/cadastro">Cadastro</a>
                <a href="http://localhost:8000/cliente">Clientes</a>
                <a href="http://localhost:8000/produtos">Produtos</a>
                <a href="http://localhost:8000/financeiro">Financeiro</a>
                <a href="http://localhost:8000/fornecedores">Fornecedores</a>
            </ul>
        </nav>
    </header>

    <div class="pdv-container">
        <h1 class="product-title">Sistema Automático de Vendas</h1>

        <div class="pdv-content">
            <section class="left-panel">
                <div class="input-group">
                    <label>Código do Produto</label>
                    <input type="text" id="codigo" placeholder="Digite o código">
                </div>
               
               <!-- MODIFICAÇÃO 1: Removida a câmera e adicionado leitor físico -->
               <div class="input-group">
                    <label>Leitor de Código de Barras Físico</label>
                    <input type="text" id="codigo_barras" placeholder="Passe o código de barras" autofocus>
                    <small style="color: #777; display: block; margin-top: 5px;">
                        ⚠️ Use um leitor físico. Passe o código e pressione Enter.
                    </small>
                </div>
                
                <div class="input-group">
                    <label>Quantidade</label>
                    <input type="number" id="quantidade" value="1" min="0.01" step="0.01">
                </div>
                
                <div class="input-group">
                    <label>Valor Unitário (R$)</label>
                    <input type="text" id="valorUnitario" value="0,00" readonly>
                </div>
                
                <div class="input-group">
                    <label>Valor Total</label>
                    <input type="text" id="valorTotal" readonly>
                </div>

                <button class="btn-venda" onclick="adicionarItem()">ADICIONAR ITEM</button>
            </section>

            <section class="right-panel">
                <div class="nota">
                    <!-- MODIFICAÇÃO 2: Adicionado ícone de impressora -->
                    <div class="print-icon" onclick="imprimirNotaFiscal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <path d="M6 14h12v8H6z"/>
                        </svg>
                    </div>
                    <pre id="notaFiscal"><strong>ITEM  CÓDIGO     DESCRIÇÃO               VL.UNIT.  ITENS(R$)</strong></pre>
                </div>

                <div class="totais">
                    <div class="volumes">
                        <label>Volumes</label>
                        <input type="text" id="volumes" value="0" readonly>
                    </div>
                    <div class="total-venda">
                        <label>Total da Venda</label>
                        <div class="total-destaque" id="totalVenda">R$ 0,00</div>
                    </div>
                </div>
            </section>     
        </div>
        
        <section class="pay">
            <div class="input-group" style="position: relative;">
                <label>Cliente</label>
                <input type="text" id="cliente" placeholder="Nome do Cliente">
                <div id="resultadoCliente" style="display: none;"></div>
            </div>
            
            <div class="total-pagamento">
                <div class="valor-pago">
                    <label>Valor Pago</label>
                    <input type="text" id="valorPago" placeholder="0,00">
                </div>
                <div class="troco">
                    <label>Troco</label>
                    <input type="text" id="troco" readonly>
                </div>    
            </div>

            <div class="input-group">
                <label>Forma de Pagamento</label>
                <select id="formaPagamento">
                    <option value="pix">Pix</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="cartao-debito">Cartão de Débito</option>
                    <option value="cartao-credito">Cartão de Crédito</option>
                </select>
            </div>
            
            <!-- MODIFICAÇÃO 3: Alterado para apenas "FINALIZAR VENDA" -->
            <button type="button" class="btn-venda" onclick="finalizarVenda()">FINALIZAR VENDA</button>
            <button class="btn-venda" style="background: #e74c3c;" onclick="limparVenda()">CANCELAR VENDA</button>
        </section>
    </div>

   <script>
    // Variáveis globais
    let contadorItem = 1;
    let totalVenda = 0;
    let totalItens = 0;
    let produtosSelecionados = [];
    let clienteSelecionado = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Focar automaticamente no campo de código de barras
    document.getElementById('codigo_barras').focus();

    // Leitor de código de barras físico (tecla Enter)
    document.getElementById('codigo_barras').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const codigoBarras = this.value.trim();
            if (codigoBarras) {
                // Dispara a busca automática
                this.dispatchEvent(new Event('blur'));
            }
        }
    });

    // Formatar números para R$
    function formatarNumero(valor) {
        const numero = parseFloat(valor);
        return isNaN(numero) ? '0,00' : numero.toFixed(2).replace('.', ',');
    }

    // Atualiza o valor total do item baseado na quantidade e preço unitário
    function atualizarValorTotal() {
        const quantidade = parseFloat(document.getElementById('quantidade').value) || 0;
        const valorUnitario = parseFloat(document.getElementById('valorUnitario').value.replace(',', '.')) || 0;
        const valorTotal = quantidade * valorUnitario;
        document.getElementById('valorTotal').value = formatarNumero(valorTotal);
    }

    // Buscar produto pelo código normal
    async function buscarProduto(codigo) {
        try {
            const response = await fetch(`/api/produtos/${codigo}`);
            if (!response.ok) return null;
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar produto:', error);
            return null;
        }
    }

    // Buscar produto pelo código de barras
    async function buscarProdutoPorCodigoBarras(codigoBarras) {
        try {
            const response = await fetch(`/api/produtos/codigo-barras/${codigoBarras}`);
            if (!response.ok) return null;
            return await response.json();
        } catch (error) {
            console.error('Erro ao buscar produto por código de barras:', error);
            return null;
        }
    }

    // Buscar cliente pelo nome
    async function buscarCliente(nome) {
        try {
            const response = await fetch(`/api/buscar-cliente/${encodeURIComponent(nome)}`);
            if(!response.ok) return null;
            return await response.json();
        } catch (error){
            console.error('Erro ao buscar cliente', error);
            return null;
        }
    }

    // Selecionar cliente
    function selecionarCliente(id, nome) {
        clienteSelecionado = id;
        document.getElementById('cliente').value = nome;
        const resultado = document.getElementById('resultadoCliente');
        if (resultado) resultado.style.display = 'none';
    }

    // Preencher valor unitário ao digitar o código normal
    document.getElementById('codigo').addEventListener('blur', async function () {
        const codigo = this.value.trim();
        if (!codigo) return;

        const produto = await buscarProduto(codigo);
        if (produto && produto.preco_saida) {
            document.getElementById('valorUnitario').value = formatarNumero(produto.preco_saida);
            // Preenche também o campo código de barras se existir
            if (produto.codigo_barras) {
                document.getElementById('codigo_barras').value = produto.codigo_barras;
            }
            atualizarValorTotal();
        } else {
            alert('Produto não encontrado');
            document.getElementById('valorUnitario').value = '0,00';
            document.getElementById('valorTotal').value = '0,00';
        }
    });

    // Preencher valor unitário ao digitar o código de barras
    document.getElementById('codigo_barras').addEventListener('blur', async function () {
        const codigoBarras = this.value.trim();
        if (!codigoBarras) return;

        const produto = await buscarProdutoPorCodigoBarras(codigoBarras);
        if (produto && produto.preco_saida) {
            document.getElementById('valorUnitario').value = formatarNumero(produto.preco_saida);
            // Preenche também o campo código normal se necessário
            document.getElementById('codigo').value = produto.codigo || produto.id || '';
            atualizarValorTotal();
            
            // Focar na quantidade após ler código de barras
            document.getElementById('quantidade').focus();
            document.getElementById('quantidade').select();
        } else {
            alert('Produto não encontrado pelo código de barras');
            document.getElementById('valorUnitario').value = '0,00';
            document.getElementById('valorTotal').value = '0,00';
        }
    });

    // Atualizar valor total quando mudar a quantidade
    document.getElementById('quantidade').addEventListener('input', atualizarValorTotal);

    // Função para adicionar item
    async function adicionarItem() {
        let codigo = document.getElementById('codigo').value.trim();
        const codigoBarras = document.getElementById('codigo_barras').value.trim();
        const quantidade = parseFloat(document.getElementById('quantidade').value) || 0;
        const valorUnitarioInput = document.getElementById('valorUnitario').value;

        // Se o código de barras estiver preenchido, priorize ele
        const codigoParaBusca = codigoBarras || codigo;
        
        if (!codigoParaBusca || quantidade <= 0 || valorUnitarioInput === '0,00') {
            alert("Preencha todos os campos corretamente.");
            return;
        }

        const valorUnitario = parseFloat(valorUnitarioInput.replace(',', '.'));
        const valorTotalItem = quantidade * valorUnitario;

        // Buscar produto - prioriza código de barras se disponível
        let produto = null;
        if (codigoBarras) {
            produto = await buscarProdutoPorCodigoBarras(codigoBarras);
        } else {
            produto = await buscarProduto(codigo);
        }
        
        if (!produto) {
            alert('Produto não encontrado');
            return;
        }

        // Deduzir do banco imediatamente - COM TRATAMENTO DE ERRO
        try {
            await atualizarEstoque(produto.id, quantidade);
        } catch (error) {
            alert("Erro ao atualizar estoque: " + error.message);
            return; // Não adiciona o item se falhar
        }

        // Adicionar produto à lista
        produtosSelecionados.push({
            id: produto.id,
            nome: produto.nome_produto,
            quantidade: quantidade,
            preco_unitario: valorUnitario
        });

        // Atualizar totais
        totalVenda += valorTotalItem;
        totalItens += quantidade;

        // Atualizar interface (nota fiscal)
        const nota = document.getElementById('notaFiscal');
        const codigoExibicao = codigoBarras || codigo;
        nota.innerHTML += `\n${String(contadorItem).padStart(3, '0')}   ${codigoExibicao.padEnd(13)} ${produto.nome_produto.substring(0, 20).padEnd(20)} ${formatarNumero(valorUnitario).padStart(8)}   ${formatarNumero(valorTotalItem).padStart(8)}`;

        document.getElementById('volumes').value = totalItens;
        document.getElementById('totalVenda').innerText = "R$ " + formatarNumero(totalVenda);

        contadorItem++;

        // Limpar campos
        document.getElementById('codigo').value = '';
        document.getElementById('codigo_barras').value = '';
        document.getElementById('quantidade').value = 1;
        document.getElementById('valorUnitario').value = '0,00';
        document.getElementById('valorTotal').value = '';
        
        // Voltar o foco para o leitor de código de barras
        document.getElementById('codigo_barras').focus();
    }

    // Buscar cliente em tempo real
    document.getElementById('cliente').addEventListener('input', async function(){
        const nome = this.value.trim();
        const resultado = document.getElementById('resultadoCliente');

        if (nome.length < 3) {
            resultado.style.display = 'none';
            return;
        }

        const cliente = await buscarCliente(nome);
        if (cliente && !cliente.error) {
            resultado.innerHTML = `
                <div onclick="selecionarCliente(${cliente.id}, '${cliente.nome.replace(/'/g, "\\'")}')">
                    ${cliente.nome} - ${cliente.telefone || 'Sem telefone'}
                </div>
            `;
            resultado.style.display = 'block';
        } else {
            resultado.innerHTML = '<div>Cliente não encontrado</div>';
            resultado.style.display = 'block';
        }
    });

    // Calcular troco
    function calcularTroco() {
        const valorPago = parseFloat(document.getElementById('valorPago').value.replace(',', '.')) || 0;
        const troco = valorPago - totalVenda;
        document.getElementById('troco').value = troco >= 0 ? formatarNumero(troco) : '0,00';
    }

    // Função para finalizar venda (sem impressão automática)
async function finalizarVenda() {
    if (produtosSelecionados.length === 0) {
        alert("Adicione pelo menos um produto!");
        return;
    }

    const cliente = document.getElementById('cliente').value.trim();
    const formaPagamento = document.getElementById('formaPagamento').value;

    try {
        const response = await fetch('/vendas/finalizar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                cliente: cliente,
                cliente_id: clienteSelecionado,
                forma_pagamento: formaPagamento,
                total: totalVenda,
                itens: produtosSelecionados.map(item => ({
                    produto_id: item.id,
                    quantidade: item.quantidade,
                    preco: item.preco_unitario
                }))
            })
        });

        const result = await response.json();

        alert('Venda registrada e estoque atualizado com sucesso!');
        limparVenda();

        // Redirecionar para o financeiro
        window.location.href = 'http://localhost:8000/financeiro';

    } catch (error) {
        alert('Erro ao finalizar venda. Tente novamente.');
        console.error(error);
    }
}


    // Limpar venda
    function limparVenda() {
        contadorItem = 1;
        totalVenda = 0;
        totalItens = 0;
        produtosSelecionados = [];
        clienteSelecionado = null;

        document.getElementById('notaFiscal').innerHTML = '<strong>ITEM  CÓDIGO     DESCRIÇÃO               VL.UNIT.  ITENS(R$)</strong>';
        document.getElementById('volumes').value = '0';
        document.getElementById('totalVenda').innerText = 'R$ 0,00';
        document.getElementById('cliente').value = '';
        document.getElementById('valorPago').value = '';
        document.getElementById('troco').value = '';
        document.getElementById('formaPagamento').selectedIndex = 0;
        document.getElementById('codigo').value = '';
        document.getElementById('codigo_barras').value = '';
        document.getElementById('quantidade').value = 1;
        document.getElementById('valorUnitario').value = '0,00';
        document.getElementById('valorTotal').value = '';
        
        // Focar no leitor de código de barras após limpar
        document.getElementById('codigo_barras').focus();
    }

    // MODIFICAÇÃO 2: Função para imprimir nota fiscal (chamada pelo ícone)
    function imprimirNotaFiscal() {
        if (produtosSelecionados.length === 0) {
            alert("Não há itens na nota fiscal para imprimir!");
            return;
        }

        // Criar um elemento temporário para a impressão
        const conteudoImpressao = document.createElement('div');
        conteudoImpressao.style.fontFamily = 'monospace';
        conteudoImpressao.style.padding = '20px';
        conteudoImpressao.style.fontSize = '14px';
        conteudoImpressao.style.lineHeight = '1.4';
        
        // Obter data e hora atual
        const agora = new Date();
        const dataHora = agora.toLocaleString('pt-BR');
        
        // Construir conteúdo da nota fiscal
        let html = `
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">VENDA FÁCIL</h2>
                <p style="margin: 5px 0;">Sistema de Gestão Comercial</p>
            </div>
            
            <div style="margin-bottom: 15px;">
                <p><strong>Data/Hora:</strong> ${dataHora}</p>
                <p><strong>Cliente:</strong> ${document.getElementById('cliente').value || 'Consumidor'}</p>
                <p><strong>Pagamento:</strong> ${document.getElementById('formaPagamento').value}</p>
            </div>
            
            <hr style="border-top: 1px dashed #000; margin: 15px 0;">
            
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; border-bottom: 1px solid #000;">Item</th>
                        <th style="text-align: left; border-bottom: 1px solid #000;">Descrição</th>
                        <th style="text-align: right; border-bottom: 1px solid #000;">Qtd</th>
                        <th style="text-align: right; border-bottom: 1px solid #000;">Unitário</th>
                        <th style="text-align: right; border-bottom: 1px solid #000;">Total</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        // Adicionar itens
        produtosSelecionados.forEach((item, index) => {
            html += `
                <tr>
                    <td style="padding: 4px 0;">${index + 1}</td>
                    <td style="padding: 4px 0;">${item.nome}</td>
                    <td style="text-align: right; padding: 4px 0;">${item.quantidade}</td>
                    <td style="text-align: right; padding: 4px 0;">R$ ${formatarNumero(item.preco_unitario)}</td>
                    <td style="text-align: right; padding: 4px 0;">R$ ${formatarNumero(item.quantidade * item.preco_unitario)}</td>
                </tr>
            `;
        });
        
        html += `
                </tbody>
            </table>
            
            <hr style="border-top: 1px dashed #000; margin: 15px 0;">
            
            <div style="text-align: right; font-weight: bold; font-size: 16px;">
                Total: R$ ${formatarNumero(totalVenda)}
            </div>
            
            <div style="margin-top: 20px; text-align: center;">
                <p>Obrigado pela preferência!</p>
                <p>Volte sempre!</p>
            </div>
        `;
        
        conteudoImpressao.innerHTML = html;
        
        // Abrir janela de impressão
        const janelaImpressao = window.open('', '_blank', 'width=800,height=600');
        janelaImpressao.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Nota Fiscal - Venda Fácil</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 0; 
                        padding: 20px; 
                        color: #000; 
                    }
                    @media print {
                        body { 
                            margin: 0; 
                            padding: 15px; 
                        }
                        .no-print { 
                            display: none !important; 
                        }
                    }
                </style>
            </head>
            <body>
                <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                    <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Imprimir Nota Fiscal
                    </button>
                    <button onclick="window.close()" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
                        Fechar
                    </button>
                </div>
                ${conteudoImpressao.innerHTML}
            </body>
            </html>
        `);
        janelaImpressao.document.close();
        
        // Focar na janela de impressão
        janelaImpressao.focus();
    }

    // Event Listeners para Enter
    ['codigo', 'codigo_barras', 'quantidade', 'valorUnitario'].forEach(id => {
        document.getElementById(id).addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (id === 'codigo' || id === 'codigo_barras') {
                    this.blur(); // Dispara a busca do produto
                } else {
                    adicionarItem();
                }
            }
        });
    });

    // Calcular troco em tempo real
    document.getElementById('valorPago').addEventListener('input', calcularTroco);
    
    // Fechar resultados de busca ao clicar fora
    document.addEventListener('click', function(e) {
        if (!document.getElementById('cliente').contains(e.target) && 
            !document.getElementById('resultadoCliente').contains(e.target)) {
            document.getElementById('resultadoCliente').style.display = 'none';
        }
    });

    async function atualizarEstoque(produtoId, quantidade) {
        try {
            const response = await fetch('/api/produtos/deduzir-estoque', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    produto_id: produtoId,
                    quantidade: quantidade
                })
            });

            // Verificar se a resposta é JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Se não for JSON, ler como texto para debug
                const textResponse = await response.text();
                console.error("Resposta não-JSON do servidor:", textResponse.substring(0, 200));
                throw new Error('Resposta do servidor não é JSON. Possível erro de rota ou servidor.');
            }

            const result = await response.json();

            if(!response.ok) {
                console.error("Erro ao atualizar estoque:", result.erro || result.mensagem);
                throw new Error(result.erro || "Erro ao atualizar estoque");
            }
            
            return result;
        } catch (error) {
            console.error("Erro ao conectar API de estoque:", error);
            throw error; // Propagar o erro para ser tratado por quem chama
        }
    }
</script>

</body>
</html>