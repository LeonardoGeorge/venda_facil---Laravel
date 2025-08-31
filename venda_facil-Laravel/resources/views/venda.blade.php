<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Vendas - Supermercado</title>
    <link rel="stylesheet" href="style.css">
    
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
                <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
                <li><a href="http://localhost:8000/clientes">Clientes</a></li>
                <li><a href="http://localhost:8000/produtos">Produtos</a></li>
                <li><a href="http://localhost:8000/financeiro">Financeiro</a></li>
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
               
               <div class="input-group">
                    <label>Leitor de Códigos (via Câmera)</label>
                    <input type="text" id="codigo_barras" placeholder="Digite o codigo de barras">
                    <div id="leitor-barcode" class="scanner-container">
                        <p style="color: #777;">A câmera aparecerá aqui quando ativada</p>
                    </div>
                    <button type="button" class="scanner-btn" onclick="iniciarScanner()">Ativar Câmera</button>
                </div>
                
                <div class="input-group">
                    <label>Quantidade</label>
                    <input type="number" id="quantidade" value="1" min="1">
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
            
            <button class="btn-venda" onclick="finalizarVenda()">FINALIZAR VENDA</button>
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

    // Buscar produto pelo código de barras (NOVO)
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

    // Preencher valor unitário ao digitar o código de barras (NOVO)
    document.getElementById('codigo_barras').addEventListener('blur', async function () {
        const codigoBarras = this.value.trim();
        if (!codigoBarras) return;

        const produto = await buscarProdutoPorCodigoBarras(codigoBarras);
        if (produto && produto.preco_saida) {
            document.getElementById('valorUnitario').value = formatarNumero(produto.preco_saida);
            // Preenche também o campo código normal se necessário
            document.getElementById('codigo').value = produto.codigo || '';
            atualizarValorTotal();
        } else {
            alert('Produto não encontrado pelo código de barras');
            document.getElementById('valorUnitario').value = '0,00';
            document.getElementById('valorTotal').value = '0,00';
        }
    });

    // Atualizar valor total quando mudar a quantidade
    document.getElementById('quantidade').addEventListener('input', atualizarValorTotal);

    // Função para adicionar item (MODIFICADA para aceitar ambos os códigos)
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

        // Deduzir do banco imediatamente
        await atualizarEstoque(produto.id, quantidade);

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
        document.getElementById('codigo').focus();
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

    // Finalizar venda
    async function finalizarVenda() {
        if (produtosSelecionados.length === 0) {
            alert("Adicione pelo menos um produto!");
            return;
        }

        const cliente = document.getElementById('cliente').value.trim();
        const formaPagamento = document.getElementById('formaPagamento').value;

        try {
            const response = await fetch('/venda/finalizar', {
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

            if (response.ok) {
                alert('Venda registrada e estoque atualizado com sucesso!');
                limparVenda();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro ao finalizar venda:', error);
            alert('Erro ao finalizar venda!');
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
        
        // Parar o scanner se estiver ativo
        if (typeof Quagga !== 'undefined' && Quagga.isActive) {
            Quagga.stop();
        }
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

            const result = await response.json();

            if(!response.ok) {
                console.error("Erro ao atualizar estoque:", result.mensagem || result);
                alert("Não foi possível atualizar o estoque deste item.");
            }
        } catch (error) {
            console.error("Erro ao conectar API de estoque:", error);
        }
    }
    
    // Iniciar scanner de código de barras
    function iniciarScanner() {
        Quagga.init({
            inputStream: {
                type: "LiveStream",
                target: document.querySelector('#leitor-barcode'),
                constraints: {
                    width: 400,
                    height: 300,
                    facingMode: "environment" 
                }
            },
            decoder: {
                readers: ["ean_reader", "code_128_reader", "upc_reader"]
            }
        }, function(err) {
            if (err) {
                console.error(err);
                alert("Erro ao iniciar câmera: " + (err.message || "Verifique as permissões da câmera"));
                return;
            }
            console.log("Scanner inicializado com sucesso");
            Quagga.start();
        });

        // Quando encontrar um código de barras
        Quagga.onDetected(function(data) {
            let codigoBarras = data.codeResult.code;
            console.log("Código de barras detectado:", codigoBarras);

            // Preenche o campo código de barras
            document.getElementById('codigo_barras').value = codigoBarras;

            // Dispara o evento blur para buscar o produto automaticamente
            document.getElementById('codigo_barras').dispatchEvent(new Event('blur'));

            // Para o scanner depois de ler
            Quagga.stop();
        });
    }
</script>

<!-- Biblioteca QuaggaJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

</body>
</html>