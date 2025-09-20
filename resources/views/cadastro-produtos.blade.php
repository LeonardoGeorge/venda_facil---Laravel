<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>VendaFácil - Produtos</title>
    <style>
        /* Mesmo estilo usado na página de fornecedores */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          font-family: 'Segoe UI', sans-serif;
          background-color: #000000;
          color: #333;
        }

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

        form label {
          display: block;
          margin-bottom: 6px;
          font-weight: bold;
        }

        .leitor-container {
          margin-bottom: 15px;
          padding: 10px;
          background-color: #f9f9f9;
          border-radius: 4px;
          border: 1px solid #ddd;
          position: relative;
        }

        .leitor-info {
          font-size: 14px;
          color: #666;
          margin-top: 5px;
        }

        form input, form select {
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

        footer {
          text-align: center;
          padding: 15px;
          background-color: #1a1717;
          margin-top: 40px;
          color: #aaa;
        }

        /* Novos estilos para o leitor */
        .scanner-animation {
          width: 100%;
          height: 4px;
          background: linear-gradient(90deg, transparent, #4a86e8, transparent);
          background-size: 200% 100%;
          animation: scan 2s linear infinite;
          margin-top: 10px;
          border-radius: 2px;
          display: none;
        }

        @keyframes scan {
          0% {
            background-position: 200% 0;
          }
          100% {
            background-position: -200% 0;
          }
        }

        .leitor-status {
          text-align: center;
          padding: 8px;
          margin-top: 10px;
          font-weight: 600;
          border-radius: 4px;
          background-color: #f8f9fa;
          border: 1px solid #ddd;
          font-size: 14px;
        }

        .leitor-conectado {
          background-color: #d4edda;
          color: #155724;
          border-color: #c3e6cb;
        }

        .leitor-aguardando {
          background-color: #fff3cd;
          color: #856404;
          border-color: #ffeeba;
        }

        .leitor-erro {
          background-color: #f8d7da;
          color: #721c24;
          border-color: #f5c6cb;
        }

        .test-area {
          margin-top: 20px;
          padding: 15px;
          background-color: #f0f7ff;
          border-radius: 8px;
          border-left: 4px solid #4a86e8;
        }

        .test-buttons {
          display: flex;
          gap: 10px;
          margin-top: 10px;
          flex-wrap: wrap;
        }

        .test-btn {
          padding: 8px 12px;
          background-color: #4a86e8;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-size: 14px;
        }

        .test-btn:hover {
          background-color: #3a76d8;
        }

        .status-message {
          margin-top: 10px;
          padding: 10px;
          border-radius: 4px;
          text-align: center;
          display: none;
          font-weight: 600;
        }

        .status-success {
          background-color: #d4edda;
          color: #155724;
          border: 1px solid #c3e6cb;
        }

        .status-error {
          background-color: #f8d7da;
          color: #721c24;
          border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
          main {
            margin: 20px;
            padding: 20px;
          }
          
          header {
            flex-direction: column;
            text-align: center;
            padding: 15px;
          }
          
          nav {
            margin-top: 15px;
          }
          
          nav a {
            margin: 0 10px;
            display: inline-block;
          }

          .test-buttons {
            flex-direction: column;
          }
        }
    </style>
</head>

<body>
    <header>
        <h1>Cadastro de Produtos</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/clientes">Clientes</a>
            <a href="http://localhost:8000/fornecedores">Fornecedores</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Dados do Produto</h2>
            @if (session('success'))
              <p style="color: green">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <div style="color: red">
                  <ul>
                    @foreach ($errors->all() as $erro)
                      <li>{{ $erro }}</li>
                    @endforeach
                  </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('cadastro.produtos.store') }}"> 
                @csrf
                <label>Nome do Produto:</label>
                <input type="text" name="nome_produto" required>

                <div class="leitor-container">
                    <label for="codigo_barras">Código de Barras:</label>
                    <input type="text" id="codigo_barras" name="codigo_barras" required autofocus>
                    <div class="scanner-animation" id="scanner-animation"></div>
                    <p class="leitor-info">⚠️ Use um leitor físico de código de barras. Passe o código e pressione Enter.</p>
                    <div class="leitor-status" id="leitor-status">Status: Aguardando leitura...</div>
                </div>

                <label>Categoria:</label>
                <input type="text" name="categoria" required>

                <label>Preço de Entrada (R$):</label>
                <input type="number" step="0.01" name="preco_entrada" required>

                <label>Preço de Saída (R$):</label>
                <input type="number" step="0.01" name="preco_saida" required>

                <label>Quantidade em Estoque:</label>
                <input type="number" name="quantidade" required>

                <label>Fornecedor:</label>
                <input type="text" name="fornecedor">

                <button type="submit">Cadastrar Produto</button>
            </form>

            <!-- Área de teste para o leitor -->
            <div class="test-area">
                <h3>Teste do Leitor de Código de Barras</h3>
                <p>Teste se o leitor está funcionando corretamente:</p>
                
                <div class="test-buttons">
                    <button class="test-btn" onclick="simularLeitura('7891000315507')">Simular Leitor 1</button>
                    <button class="test-btn" onclick="simularLeitura('7891910000197')">Simular Leitor 2</button>
                    <button class="test-btn" onclick="simularLeitura('7896036093291')">Simular Leitor 3</button>
                </div>
                
                <div class="status-message" id="status-message"></div>
            </div>
        </section>
    </main>

    <footer>
        <p>Sistema VendaFácil &copy; 2023</p>
    </footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoBarrasInput = document.getElementById('codigo_barras');
    const scannerAnimation = document.getElementById('scanner-animation');
    const leitorStatus = document.getElementById('leitor-status');
    const statusMessage = document.getElementById('status-message');
    
    // Focar automaticamente no campo de código de barras
    codigoBarrasInput.focus();
    
    // Verificar se já existe um código de barras (para evitar dupla leitura)
    let codigoLido = false;
    
    // Mostrar animação quando o campo receber foco
    codigoBarrasInput.addEventListener('focus', () => {
        scannerAnimation.style.display = 'block';
        leitorStatus.textContent = "Status: Pronto para leitura (campo em foco)";
        leitorStatus.className = "leitor-status leitor-conectado";
    });
    
    // Ocultar animação quando o campo perder o foco
    codigoBarrasInput.addEventListener('blur', () => {
        scannerAnimation.style.display = 'none';
        leitorStatus.textContent = "Status: Aguardando foco no campo";
        leitorStatus.className = "leitor-status leitor-aguardando";
    });
    
    // Event listener para leitor de código de barras (tecla Enter)
    codigoBarrasInput.addEventListener('keydown', function(e) {
        // Se for a tecla Enter e o campo não estiver vazio
        if (e.key === 'Enter' && this.value.trim() !== '') {
            e.preventDefault();
            
            // Se já leu um código, não faz nada
            if (codigoLido) {
                return;
            }
            
            // Verificar se é um código de barras válido (pelo menos 8 dígitos)
            if (this.value.replace(/\D/g, '').length >= 8) {
                codigoLido = true;
                
                // Atualizar status
                leitorStatus.textContent = "Status: Leitura bem-sucedida!";
                leitorStatus.className = "leitor-status leitor-conectado";
                
                // Mostrar mensagem de sucesso
                mostrarStatus('Código lido com sucesso: ' + this.value, 'success');
                
                // Buscar informações do produto se existir
                buscarProdutoPorCodigo(this.value);
                
                // Destacar visualmente o campo
                this.style.backgroundColor = '#e8f5e8';
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 1000);
            } else {
                mostrarStatus('Erro: Código de barras inválido. Deve ter pelo menos 8 dígitos.', 'error');
                leitorStatus.textContent = "Status: Erro na leitura";
                leitorStatus.className = "leitor-status leitor-erro";
            }
        }
    });
    
    // Detectar quando um código é inserido (pelo leitor ou manualmente)
    codigoBarrasInput.addEventListener('input', function() {
        codigoLido = false;
        
        if (this.value.length > 0) {
            leitorStatus.textContent = "Status: Código detectado - pressione Enter";
            leitorStatus.className = "leitor-status leitor-conectado";
        } else {
            leitorStatus.textContent = "Status: Aguardando leitura";
            leitorStatus.className = "leitor-status leitor-aguardando";
        }
    });
    
    // Função para buscar produto por código de barras
    function buscarProdutoPorCodigo(codigo) {
        fetch(`/api/produtos/codigo-barras/${codigo}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Produto não encontrado');
                }
                return response.json();
            })
            .then(produto => {
                // Se o produto já existe, preencher os campos automaticamente
                document.querySelector('input[name="nome_produto"]').value = produto.nome_produto;
                document.querySelector('input[name="categoria"]').value = produto.categoria || '';
                document.querySelector('input[name="preco_saida"]').value = produto.preco_saida;
                document.querySelector('input[name="quantidade"]').value = 1;
                
                mostrarStatus('Produto encontrado! Campos preenchidos automaticamente.', 'success');
            })
            .catch(error => {
                console.log('Produto não cadastrado: ' + error.message);
                // Não faz nada se o produto não existir (é um novo produto)
            });
    }
    
    // Função para mostrar mensagens de status
    function mostrarStatus(mensagem, tipo) {
        statusMessage.textContent = mensagem;
        statusMessage.className = `status-message status-${tipo}`;
        statusMessage.style.display = 'block';
        
        // Ocultar a mensagem após 3 segundos
        setTimeout(() => {
            statusMessage.style.display = 'none';
        }, 3000);
    }
    
    // Função para simular leitura (usada pelos botões de teste)
    window.simularLeitura = function(codigo) {
        // Mostrar animação de leitura
        scannerAnimation.style.display = 'block';
        leitorStatus.textContent = "Status: Simulando leitura...";
        leitorStatus.className = "leitor-status leitor-conectado";
        
        // Simular o tempo de leitura
        setTimeout(() => {
            codigoBarrasInput.value = codigo;
            
            // Disparar evento de input
            const event = new Event('input', { bubbles: true });
            codigoBarrasInput.dispatchEvent(event);
            
            // Mostrar mensagem de sucesso
            mostrarStatus('Leitura simulada bem-sucedida! Código: ' + codigo, 'success');
            
            // Simular pressionar Enter após a leitura
            setTimeout(() => {
                const enterEvent = new KeyboardEvent('keydown', { key: 'Enter' });
                codigoBarrasInput.dispatchEvent(enterEvent);
                
                // Ocultar animação após um tempo
                setTimeout(() => {
                    scannerAnimation.style.display = 'none';
                }, 500);
            }, 300);
        }, 800);
    };
});
</script>

</body>
</html>