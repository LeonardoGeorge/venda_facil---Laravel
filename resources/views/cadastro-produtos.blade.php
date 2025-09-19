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
                    <p class="leitor-info">⚠️ Use um leitor físico de código de barras. Passe o código e pressione Enter.</p>
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
        </section>
    </main>

    <footer>
        <p>Sistema VendaFácil &copy; 2023</p>
    </footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoBarrasInput = document.getElementById('codigo_barras');
    
    // Focar automaticamente no campo de código de barras
    codigoBarrasInput.focus();
    
    // Verificar se já existe um código de barras (para evitar dupla leitura)
    let codigoLido = false;
    
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
                
                // Buscar informações do produto se existir
                buscarProdutoPorCodigo(this.value);
                
                // Opcional: avisar que o código foi lido
                this.style.backgroundColor = '#e8f5e8';
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 1000);
            }
        }
    });
    
    // Permitir nova leitura se o usuário alterar manualmente o código
    codigoBarrasInput.addEventListener('input', function() {
        codigoLido = false;
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
                
                alert('Produto encontrado! Campos preenchidos automaticamente.');
            })
            .catch(error => {
                console.log('Produto não cadastrado: ' + error.message);
                // Não faz nada se o produto não existir (é um novo produto)
            });
    }
});
</script>

</body>
</html>