<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Vendas - Supermercado</title>
    <link rel="stylesheet" href="style.css">
    <style>
    /* SEU CSS PERMANECE EXATAMENTE IGUAL */
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #000000;
    }

    a {
        text-decoration: none;
        color: inherit;
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
        color: #fff;
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
        color: rgb(250, 234, 234);
        text-decoration: none;
        font-size: 16px;
    }

    .menu li a:hover {
        color: #7ac943;
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
    }

    .btn-solid {
        background: #7ac943;
        color: black;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
    }

    .pdv-container {
        padding: 20px;
    }

    .product-title {
        text-align: center;
        background-color: #000000;
        color: white;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
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
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .product-image {
        text-align: center;
        margin-bottom: 15px;
    }

    .product-image img {
        width: 150px;
        height: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .input-group {
        margin-bottom: 10px;
    }

    .input-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .input-group input {
        width: 100%;
        padding: 6px;
        font-size: 16px;
        border: 1px solid #aaa;
        border-radius: 4px;
    }

    .btn-venda {
        width: 100%;
        padding: 15px;
        font-size: 20px;
        background-color: #7ac943;
        color: white;
        font-weight: bold;
        border: none;
        margin-top: 15px;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-venda:hover {
        background-color: #38770c;
    }

    .nota pre {
        background: #f1f1f1;
        padding: 10px;
        font-family: monospace;
        border: 1px solid #ccc;
        height: 240px;
        overflow-y: auto;
        white-space: pre-wrap;
        border-radius: 4px;
    }

    .totais {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        gap: 10px;
    }

    .volumes input {
        width: 100px;
        padding: 6px;
        font-size: 16px;
    }

    .total-venda {
        text-align: right;
    }

    .total-venda label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .total-destaque {
        font-size: 24px;
        font-weight: bold;
        color: red;
    }

    .pay {
        margin-top: 20px;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
    }

    .total-pagamento {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .valor-pago, .troco {
        flex: 1;
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
                <li><a href="http://localhost:8000/estoque">Estoque</a></li>
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
                    <label>Produto</label>
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
            <div class="input-group">
                <label>Cliente</label>
                <input type="text" id="cliente" placeholder="Nome do Cliente">
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
        </section>
    </div>


   <script>
    // Variáveis globais
    let contadorItem = 1;
    let totalVenda = 0;
    let totalItens = 0;
    let produtosSelecionados = [];
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

    // Buscar produto pelo código
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

    // Buscar cliente pelo nome
    async function buscarCliente(nome) {
        try {
            const response = await fetch(`/buscar-cliente/${encodeURIComponent(nome)}`);
            if(!response.ok) return null;
            return await response.json();
        } catch (error){
            console.error('Erro ao buscar cliente', error);
            return null;
        }
    }

    // Preencher valor unitário ao digitar o código
    document.getElementById('codigo').addEventListener('blur', async function () {
        const codigo = this.value.trim();
        if (!codigo) return;

        const produto = await buscarProduto(codigo);
        if (produto && produto.preco_saida) {
            document.getElementById('valorUnitario').value = formatarNumero(produto.preco_saida);
            atualizarValorTotal();
        } else {
            alert('Produto não encontrado');
            document.getElementById('valorUnitario').value = '0,00';
            document.getElementById('valorTotal').value = '0,00';
        }
    });

    // Atualizar valor total quando mudar a quantidade
    document.getElementById('quantidade').addEventListener('input', atualizarValorTotal);

    // Função para adicionar item
    async function adicionarItem() {
        const codigo = document.getElementById('codigo').value.trim();
        const quantidade = parseFloat(document.getElementById('quantidade').value) || 0;
        const valorUnitarioInput = document.getElementById('valorUnitario').value;

        if (!codigo || quantidade <= 0 || valorUnitarioInput === '0,00') {
            alert("Preencha todos os campos corretamente.");
            return;
        }

        const valorUnitario = parseFloat(valorUnitarioInput.replace(',', '.'));
        const valorTotalItem = quantidade * valorUnitario;

        // Buscar produto para pegar nome
        const produto = await buscarProduto(codigo);
        if (!produto) {
            alert('Produto não encontrado');
            return;
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
        nota.innerHTML += `\n${String(contadorItem).padStart(3, '0')}   ${codigo.padEnd(10)} ${produto.nome_produto.padEnd(20)} ${formatarNumero(valorUnitario).padStart(8)}   ${formatarNumero(valorTotalItem).padStart(8)}`;

        document.getElementById('volumes').value = totalItens;
        document.getElementById('totalVenda').innerText = "R$ " + formatarNumero(totalVenda);

        contadorItem++;

        // Limpar campos
        document.getElementById('codigo').value = '';
        document.getElementById('quantidade').value = 1;
        document.getElementById('valorUnitario').value = '0,00';
        document.getElementById('valorTotal').value = '';
        document.getElementById('codigo').focus();
    }

    // Buscar cliente em tempo real
    documente.getElementById('buscarCliente').addEventListener('input', async function(){
        const nome = this.value.trim();
        const resultado = document.getElementById('resultadoCliente');

        if (nome.length < 3) {
            resultado.style.display = 'none';
            return;
        }

        const cliente = await buscaCliente(nome);
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

    // Selecionar cliente 

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

        if (!cliente) {
            alert("Informe o nome do cliente!");
            return;
        }

        try {
            const response = await fetch('/venda/registrar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    cliente: cliente,
                    forma_pagamento: formaPagamento,
                    valor_total: totalVenda,
                    data_venda: data
                })
            });

            const result = await response.json();

            if (response.ok) {
                alert('Venda registrada com sucesso!');
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

        document.getElementById('notaFiscal').innerHTML = '<strong>ITEM  CÓDIGO     DESCRIÇÃO               VL.UNIT.  ITENS(R$)</strong>';
        document.getElementById('volumes').value = '0';
        document.getElementById('totalVenda').innerText = 'R$ 0,00';
        document.getElementById('cliente').value = '';
        document.getElementById('valorPago').value = '';
        document.getElementById('troco').value = '';
        document.getElementById('formaPagamento').selectedIndex = 0;
    }

    // Event Listeners para Enter
    ['codigo', 'quantidade', 'valorUnitario'].forEach(id => {
        document.getElementById(id).addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                adicionarItem();
            }
        });
    });

    // Calcular troco em tempo real
    document.getElementById('valorPago').addEventListener('input', calcularTroco);
       // Fechar resultados de busca ao clicar fora
    document.addEventListener('click', function(e) {
        if (!document.getElementById('cliente').contains(e.target)) {
            document.getElementById('resultadoCliente').style.display = 'none';
        }
    });
</script>

</body>
</html>