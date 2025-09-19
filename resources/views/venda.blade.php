<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda Fácil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .total-venda {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .produto-item {
            transition: background-color 0.3s;
        }
        .produto-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cash-register me-2"></i>Registrar Venda</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="codigo_barras" class="form-label">Código de Barras</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="codigo_barras" placeholder="Passe o código de barras" autofocus>
                                    <button class="btn btn-outline-secondary" type="button" id="btn-buscar-codigo">
                                        <i class="fas fa-barcode"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cliente" class="form-label">Cliente (Opcional)</label>
                                <input type="text" class="form-control" id="cliente" placeholder="Nome do cliente">
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-striped table-hover" id="tabela-itens">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Preço Unit.</th>
                                        <th>Subtotal</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="itens-venda">
                                    <!-- Itens da venda serão adicionados aqui -->
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="total-venda">Total: R$ <span id="total-venda">0,00</span></div>
                            <div>
                                <select class="form-select me-2" id="forma-pagamento" style="width: auto; display: inline-block;">
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="Cartão Débito">Cartão Débito</option>
                                    <option value="Cartão Crédito">Cartão Crédito</option>
                                    <option value="PIX">PIX</option>
                                </select>
                                <button class="btn btn-success" id="btn-finalizar-venda">
                                    <i class="fas fa-check-circle me-1"></i> Finalizar Venda
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Produtos Disponíveis</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 600px;">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-secondary sticky-top">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Estoque</th>
                                        <th>Preço</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produtos as $produto)
                                    <tr class="produto-item">
                                        <td>{{ $produto->nome_produto }}</td>
                                        <td>{{ $produto->quantidade }}</td>
                                        <td>R$ {{ number_format($produto->preco_saida, 2, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-adicionar" data-id="{{ $produto->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        let carrinho = [];
        let totalVenda = 0;

        // Focar no campo de código de barras ao carregar a página
        $('#codigo_barras').focus();

        // Evento para leitor de código de barras (tecla Enter)
        $('#codigo_barras').keypress(function(e) {
            if (e.which === 13) { // Tecla Enter
                e.preventDefault();
                buscarProdutoPorCodigoBarras($(this).val());
                $(this).val('').focus();
            }
        });

        // Botão manual para buscar por código de barras
        $('#btn-buscar-codigo').click(function() {
            let codigo = $('#codigo_barras').val();
            if (codigo) {
                buscarProdutoPorCodigoBarras(codigo);
                $('#codigo_barras').val('').focus();
            }
        });

        // Adicionar produto ao clicar no botão "+"
        $('.btn-adicionar').click(function() {
            let produtoId = $(this).data('id');
            adicionarProduto(produtoId);
        });

        // Finalizar venda
        $('#btn-finalizar-venda').click(function() {
            finalizarVenda();
        });

        // Função para buscar produto por código de barras
        function buscarProdutoPorCodigoBarras(codigoBarras) {
            $.ajax({
                url: '/vendas/buscar-produto-codigo-barras/' + codigoBarras,
                method: 'GET',
                success: function(response) {
                    adicionarProduto(response.id);
                },
                error: function(xhr) {
                    alert('Produto não encontrado! Verifique o código de barras.');
                    $('#codigo_barras').focus();
                }
            });
        }

        // Função para adicionar produto ao carrinho
        function adicionarProduto(produtoId) {
            $.ajax({
                url: '/vendas/buscar-produto/' + produtoId,
                method: 'GET',
                success: function(produto) {
                    // Verificar se o produto já está no carrinho
                    let itemExistente = carrinho.find(item => item.produto_id === produto.id);
                    
                    if (itemExistente) {
                        // Incrementar quantidade se já existir
                        itemExistente.quantidade++;
                        itemExistente.subtotal = itemExistente.quantidade * itemExistente.preco;
                        atualizarItemTabela(itemExistente);
                    } else {
                        // Adicionar novo item
                        let novoItem = {
                            produto_id: produto.id,
                            nome_produto: produto.nome_produto,
                            quantidade: 1,
                            preco: produto.preco_saida,
                            subtotal: produto.preco_saida
                        };
                        
                        carrinho.push(novoItem);
                        adicionarItemTabela(novoItem);
                    }
                    
                    atualizarTotal();
                    $('#codigo_barras').focus();
                },
                error: function() {
                    alert('Erro ao buscar produto!');
                }
            });
        }

        // Função para adicionar item na tabela
        function adicionarItemTabela(item) {
            let linha = `
                <tr id="item-${item.produto_id}">
                    <td>${item.nome_produto}</td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 100px;">
                            <button class="btn btn-outline-secondary btn-diminuir" data-id="${item.produto_id}">-</button>
                            <input type="number" class="form-control text-center quantidade" value="${item.quantidade}" min="1" data-id="${item.produto_id}">
                            <button class="btn btn-outline-secondary btn-aumentar" data-id="${item.produto_id}">+</button>
                        </div>
                    </td>
                    <td>R$ <span class="preco-unitario">${item.preco.toFixed(2).replace('.', ',')}</span></td>
                    <td>R$ <span class="subtotal">${item.subtotal.toFixed(2).replace('.', ',')}</span></td>
                    <td>
                        <button class="btn btn-sm btn-danger btn-remover" data-id="${item.produto_id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#itens-venda').append(linha);
            
            // Adicionar eventos aos botões
            $(`#item-${item.produto_id} .btn-diminuir`).click(function() {
                alterarQuantidade(item.produto_id, -1);
            });
            
            $(`#item-${item.produto_id} .btn-aumentar`).click(function() {
                alterarQuantidade(item.produto_id, 1);
            });
            
            $(`#item-${item.produto_id} .quantidade`).change(function() {
                let novaQuantidade = parseInt($(this).val());
                if (novaQuantidade < 1) novaQuantidade = 1;
                definirQuantidade(item.produto_id, novaQuantidade);
            });
            
            $(`#item-${item.produto_id} .btn-remover`).click(function() {
                removerItem(item.produto_id);
            });
        }

        // Função para atualizar item na tabela
        function atualizarItemTabela(item) {
            $(`#item-${item.produto_id} .quantidade`).val(item.quantidade);
            $(`#item-${item.produto_id} .subtotal`).text(item.subtotal.toFixed(2).replace('.', ','));
        }

        // Função para alterar quantidade
        function alterarQuantidade(produtoId, diferenca) {
            let item = carrinho.find(item => item.produto_id === produtoId);
            if (item) {
                item.quantidade += diferenca;
                if (item.quantidade < 1) item.quantidade = 1;
                item.subtotal = item.quantidade * item.preco;
                atualizarItemTabela(item);
                atualizarTotal();
            }
        }

        // Função para definir quantidade específica
        function definirQuantidade(produtoId, quantidade) {
            let item = carrinho.find(item => item.produto_id === produtoId);
            if (item) {
                item.quantidade = quantidade;
                item.subtotal = item.quantidade * item.preco;
                atualizarItemTabela(item);
                atualizarTotal();
            }
        }

        // Função para remover item
        function removerItem(produtoId) {
            carrinho = carrinho.filter(item => item.produto_id !== produtoId);
            $(`#item-${produtoId}`).remove();
            atualizarTotal();
        }

        // Função para atualizar total da venda
        function atualizarTotal() {
            totalVenda = carrinho.reduce((total, item) => total + item.subtotal, 0);
            $('#total-venda').text(totalVenda.toFixed(2).replace('.', ','));
        }

        // Função para finalizar venda
        function finalizarVenda() {
            if (carrinho.length === 0) {
                alert('Adicione pelo menos um produto para finalizar a venda!');
                return;
            }

            let formaPagamento = $('#forma-pagamento').val();
            let cliente = $('#cliente').val() || 'Cliente não informado';

            let dadosVenda = {
                cliente: cliente,
                forma_pagamento: formaPagamento,
                total: totalVenda,
                itens: carrinho
            };

            $.ajax({
                url: '/vendas/finalizar',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...dadosVenda
                },
                success: function(response) {
                    alert(response.mensagem);
                    // Limpar carrinho
                    carrinho = [];
                    $('#itens-venda').empty();
                    atualizarTotal();
                    $('#cliente').val('');
                    $('#codigo_barras').focus();
                },
                error: function(xhr) {
                    alert('Erro ao finalizar venda: ' + xhr.responseJSON.mensagem);
                }
            });
        }
    });
    </script>
</body>
</html>