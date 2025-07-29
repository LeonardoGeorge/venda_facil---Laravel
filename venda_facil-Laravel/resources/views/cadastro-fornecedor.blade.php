<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>VendaFácil - Fornecedores</title>
    
    <style>
        /* Reset básico */
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

        /* ===== HEADER ===== */
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

        /* ===== MAIN CONTENT ===== */
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

        /* ===== FORM ===== */
        form label {
          display: block;
          margin-bottom: 6px;
          font-weight: bold;
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

        small {
          display: block;
          margin-top: -10px;
          margin-bottom: 15px;
          font-size: 12px;
          color: #777;
        }

        /* ===== FOOTER ===== */
        footer {
          text-align: center;
          padding: 15px;
          background-color: #1a1717;
          margin-top: 40px;
          color: #aaa;
        }

        /* Responsividade */
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
        <h1>Cadastro de Fornecedores</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/clientes">Clientes</a>
            <a href="http://localhost:8000/produtos">Produtos</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Dados do Fornecedor</h2>
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
            <form method="POST" action="{{ route('fornecedores.store') }}">
                @csrf
                <label>Nome/Razão Social:</label>
                <input type="text" name="nome" required>
                
                <label>CNPJ:</label>
                <input type="text" name="cnpj" id="cnpj" maxlength="18" required oninput="formatarCNPJ(this)">
                <small>Formato: 00.000.000/0000-00</small>
                
                <label>Telefone:</label>
                <input type="text" name="telefone" id="telefone" required oninput="formatarTelefone(this)">
                <small>Formato: (00) 00000-0000</small>
                
                <label>Email:</label>
                <input type="email" name="email">
                
                <label>Endereço:</label>
                <input type="text" name="endereco">
                
                <label>Cidade:</label>
                <input type="text" name="cidade">
                
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="">Selecione...</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <!-- outros estados -->
                    <option value="SP">São Paulo</option>
                </select>
                
                <button type="submit">Cadastrar Fornecedor</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Sistema VendaFácil &copy; 2023</p>
    </footer>

    <script>
        function formatarCNPJ(campo) {
            let cnpj = campo.value.replace(/\D/g, '');
            cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
            cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
            cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
            campo.value = cnpj.substring(0, 18);
        }

        function formatarTelefone(campo) {
            let telefone = campo.value.replace(/\D/g, '');
            if (telefone.length > 11) telefone = telefone.substring(0, 11);
            
            if (telefone.length > 2) {
                telefone = telefone.replace(/^(\d{2})/, '($1) ');
                if (telefone.length > 10) {
                    telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2');
                } else {
                    telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
                }
            }
            campo.value = telefone;
        }
    </script>
</body>
</html>