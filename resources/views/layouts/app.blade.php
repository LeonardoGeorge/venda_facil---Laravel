<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Venda Fácil</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #000;
            color: #fff;
        }
        header {
            background-color: #111;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            color: #fff;
            font-size: 24px;
        }
        header h1 span {
            background: #7ac943;
            color: #111;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 5px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        nav a:hover { color: #7ac943; }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
        }
        .page-title {
            color: #7ac943;
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
        }
        footer {
            text-align: center;
            padding: 15px;
            color: #999;
            font-size: 14px;
            margin-top: 30px;
            border-top: 1px solid #222;
        }

        /* Estilo para tabelas */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            color: #fff;
        }
        .styled-table thead {
            background: #222;
        }
        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        .styled-table tr:hover { background: #333; }
        .btn-edit {
            background-color: #7ac943;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-edit:hover {
            background-color: #5ea730;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 4px;
            background: #111;
            color: #fff;
        }
    </style>
</head>
<body>
<header>
    <h1>Venda <span>FÁCIL</span></h1>
    <nav>
        <a href="http://localhost:8000/">Início</a>
        <a href="http://localhost:8000/venda">Vendas</a>
        <a href="http://localhost:8000/clientes">Clientes</a>
        <a href="http://localhost:8000/produtos">Produtos</a>
        <a href="http://localhost:8000/fornecedores">Fornecedores</a>
    </nav>
</header>

@yield('content')

<footer>
    &copy; {{ date('Y') }} Venda Fácil - Todos os direitos reservados.
</footer>

</body>
</html>