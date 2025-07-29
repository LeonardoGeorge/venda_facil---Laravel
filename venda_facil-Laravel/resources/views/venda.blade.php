<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Vendas - Supermercado</title>
    <link rel="stylesheet" href="style.css">

    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #000000;
    }

a {
    text-decoration: none;
    color: inherit; /* Herda a cor do elemento pai */
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



</style>
</head>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            
        }

        .pdv-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pdv-content {
            display: flex;
            justify-content: space-between;
        }

        .input-group {
            margin-bottom: 10px;
        }

        .nota {
            background-color: #eee;
            padding: 10px;
            white-space: pre-wrap;
        }

        .total-destaque {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 5px;
        }
        .pay {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
</head>

<body>
    <header class="top-bar">
        <div class="logo"><a href="#">Venda<span>FACIL</span></a></div>
        <nav>
            <ul class="menu">
                <a href="http://localhost:8000/">Início</a>
                <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
                <li><a href="#">Clientes</a></li>
                <li><a href="#">Produtos</a></li>
                <li><a href="#">Financeiro</a></li>
                <li><a href="#">Estoque</a></li>
            </ul>
        </nav>
    </header>

    <div class="pdv-container">
        <h1 class="product-title">Sistema Automático de Vendas</h1>

        <div class="pdv-content">
            <section class="left-panel">
                <div class="input-group">
                    <label>Código</label>
                    <input type="text" id="codigo" placeholder="0001">
                </div>
                <div class="input-group">
                    <label>Quantidade</label>
                    <input type="number" id="quantidade" value="1">
                </div>
                <div class="input-group">
                    <label>Valor Unitário (R$)</label>
                    <input type="text" id="valorUnitario" value="0,00" placeholder="0,00">
                </div>
                <div class="input-group">
                    <label>Valor Total</label>
                    <input type="text" id="valorTotal" readonly>
                </div>

                <button class="btn-venda" onclick="adicionarItem()">VENDA</button>
            </section>

            <section class="right-panel">
                <div class="nota" id="notaFiscal">
                    <strong>ITEM  CÓDIGO     DESCRIÇÃO               VL.UNIT.  ITENS(R$)</strong>
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
                    <div class="total-pagamento">
                        <div class="valor-pago">
                            <label>Valor Pago</label>
                            <input type="text" id="valorTotal" readonly>
                        </div>
                        <div class="troco">
                            <label>Troco</label>
                            <input type="text" id="troco" readonly>
                        </div>    
                    </div>

                    <label>Forma de Pagamento</label>
                    <select id="formaPagamento">
                        <option value="pix">Pix</option>
                        <option value="dinheiro">Dinheiro</option>
                        <option value="cartao-debito">Cartão de Debito</option>
                        <option value="cartao-debito">Cartão de Credito</option>
                    </select>
                </div>
                <button class="btn-venda" onclick="finalizarVenda()">Finalizar Venda</button>
            </section>
    </div>

     <script>
        let contadorItem = 1;
        let totalVenda = 0;
        let totalItens = 0;

        function formatarNumero(valor) {
            return parseFloat(valor).toFixed(2).replace('.', ',');
        }

        function atualizarValorTotal() {
            const quantidade = parseFloat(document.getElementById('quantidade').value) || 0;
            const valorUnitario = parseFloat(document.getElementById('valorUnitario').value.replace(',', '.')) || 0;
            const valorTotal = quantidade * valorUnitario;
            document.getElementById('valorTotal').value = formatarNumero(valorTotal);
        }

        function adicionarItem() {
            const codigo = document.getElementById('codigo').value;
            const quantidade = parseFloat(document.getElementById('quantidade').value);
            const valorUnitario = parseFloat(document.getElementById('valorUnitario').value.replace(',', '.'));

            if (!codigo || !quantidade || !valorUnitario) {
                alert("Preencha todos os campos corretamente.");
                return;
            }

            const valorTotal = quantidade * valorUnitario;
            totalVenda += valorTotal;
            totalItens += quantidade;

            const nota = document.getElementById('notaFiscal');
            nota.innerHTML += `\n${String(contadorItem).padStart(3, '0')}   ${codigo.padEnd(10)} Produto Genérico     ${formatarNumero(valorUnitario).padStart(8)}   ${formatarNumero(valorTotal).padStart(8)}`;

            document.getElementById('volumes').value = totalItens.toFixed(0);
            document.getElementById('totalVenda').innerText = "R$ " + formatarNumero(totalVenda);

            contadorItem++;

            // Limpa os campos
            document.getElementById('codigo').value = '';
            document.getElementById('quantidade').value = 1;
            document.getElementById('valorUnitario').value = '';
            document.getElementById('valorTotal').value = '';
        }

        // Atualiza valor total em tempo real
        document.getElementById('quantidade').addEventListener('input', atualizarValorTotal);
        document.getElementById('valorUnitario').addEventListener('input', atualizarValorTotal);
    
        // Executar adicionarItem() ao apertar Enter em qualquer input
['codigo', 'quantidade', 'valorUnitario'].forEach(id => {
    document.getElementById(id).addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // evita comportamento padrão
            adicionarItem();
        }
    });
});

    
    </script>
    
</body>

</html>



