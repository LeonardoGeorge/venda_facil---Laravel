<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - VendaFácil</title>
    <style>
        /* Estilos consistentes com o resto do sistema */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
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

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
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

        form input {
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

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #1a1717;
            margin-top: 40px;
            color: #fff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff2d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
    </style>
</head>
<body>
    <header>
        <h1>VendaFácil - Editar Cliente</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/cadastro">Cadastro</a>
            <a href="http://localhost:8000/clientes">Clientes</a>
        </nav>
    </header>

    <div class="container">
        <h2>Editar Cliente</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
            @csrf
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ $cliente->nome }}" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ $cliente->email }}">
            </div>

            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="{{ $cliente->telefone }}" required>
            </div>

            <div>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="{{ $cliente->cpf }}" required>
            </div>

            <div>
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="{{ $cliente->endereco }}">
            </div>

            <button type="submit">Atualizar Cliente</button>
        </form>
    </div>

    <div class="footer">
        <p>VendaFácil &copy; {{ date('Y') }} - Sistema de Gerenciamento</p>
    </div>
</body>
</html>