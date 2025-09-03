<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros - Venda Fácil</title>
    <style>
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
            max-width: 800px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #7ac943;
            transition: transform 0.3s ease;
        }

        section:hover {
            transform: translateY(-5px);
        }

        h2 {
            margin-bottom: 20px;
            color: #4d7c2b;
            border-bottom: 2px solid #7ac943;
            padding-bottom: 10px;
        }

        .action-button {
            display: inline-block;
            background-color: #7ac943;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
            text-decoration: none;
            margin-top: 15px;
        }

        .action-button:hover {
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
        <h1>VendaFácil - Sistema de Cadastros</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/clientes">Clientes</a>
            <a href="http://localhost:8000/produtos">Produtos</a>
            <a href="http://localhost:8000/fornecedores">Fornecedores</a>
        </nav>
    </header>

    <main>
        <h2>Selecione o Tipo de Cadastro</h2>
        
        <section>
            <h2>Clientes</h2>
            <p>Cadastre novos clientes no sistema para gerenciar vendas e histórico de compras.</p>
            <a href="http://localhost:8000/cadastro-clientes" class="action-button">Cadastrar Clientes</a>
        </section>
        
        <section>
            <h2>Produtos</h2>
            <p>Adicione produtos ao seu catálogo com código de barras, preços e informações de estoque.</p>
            <a href="http://localhost:8000/cadastro-produtos" class="action-button">Cadastrar Produtos</a>
        </section>
        
        <section>
            <h2>Fornecedores</h2>
            <p>Registre fornecedores para manter o controle da sua cadeia de suprimentos.</p>
            <a href="http://localhost:8000/cadastro-fornecedor" class="action-button">Cadastrar Fornecedores</a>
        </section>
    </main>

    <footer>
        <p>Criado por Leonardo George © 2025</p>
    </footer>
</body>
</html>