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

        #camera {
          position: relative;
          width: 300px;
          height: 200px;
          border: 1px solid #ccc;
          overflow: hidden; /* garante que não ultrapasse */
        }

        #camera video {
          width: 100% !important;
          height: 100% !important;
          object-fit: cover; /* corta e preenche */
          position: absolute;
          top: 0;
          left: 0;
        }
        #camera canvas {
          width: 100% !important;
          height: 100% !important;
          position: absolute;
          top: 0;
          left: 0;
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

                <label for="codigo_barras">Código de Barras:</label>
                <input type="text" id="codigo_barras" name="codigo_barras" required>
                <div id="camera" style="width: 300px; height: 200px; border: 1px solid #ccc;"></div>
                <br>
                <button type="button" id="iniciarCamera">Ler Código de Barras</button>
                <br>
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
document.getElementById('iniciarCamera').addEventListener('click', function() {
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#camera'),
            constraints: {
                facingMode: "environment" // traseira no celular, webcam no PC
            },
        },
        decoder: {
            readers: ["ean_reader", "code_128_reader"] // Tipos comuns de códigos
        },
    }, function(err) {
        if (err) {
            console.log(err);
            return;
        }
        console.log("Câmera iniciada");
        Quagga.start();
    });

    // Quando detectar código
    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;
        console.log("Código detectado: " + code);

        // Preenche o input automaticamente
        document.getElementById('codigo_barras').value = code;

        // Para a leitura (opcional, para não ficar repetindo)
        Quagga.stop();
    });
});
</script>

<script src="https://unpkg.com/quagga/dist/quagga.min.js"></script>

</body>
</html>
