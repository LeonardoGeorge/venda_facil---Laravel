<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - VendaFácil</title>
    <style>
        /* Estilos consistentes com o sistema */
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
            max-width: 1200px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .page-title {
            margin-bottom: 20px;
            color: #4d7c2b;
            border-bottom: 2px solid #7ac943;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-new {
            background-color: #7ac943;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-new:hover {
            background-color: #3b691a;
        }

        .search-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .styled-table th {
            background-color: #f8f8f8;
            font-weight: bold;
            color: #444;
        }

        .styled-table tbody tr:hover {
            background-color: #f1f9ec;
        }

        .btn-edit, .btn-delete {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #7ac943;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-edit:hover {
            background-color: #3b691a;
        }

        .btn-delete:hover {
            background-color: #c0392b;
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
        <h1>VendaFácil - Fornecedores</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/clientes">Clientes</a>
            <a href="http://localhost:8000/produtos">Produtos</a>
        </nav>
    </header>

    <div class="container">
        <div class="page-title">
            <h2>Lista de Fornecedores</h2>
            <a href="{{ route('fornecedores.create') }}" class="btn-new">Novo Fornecedor</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <input type="text" id="searchInput" placeholder="Pesquisar fornecedor..." class="search-input">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Cidade/UF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fornecedores as $fornecedor)
                <tr>
                    <td>{{ $fornecedor->id }}</td>
                    <td>{{ $fornecedor->nome }}</td>
                    <td>{{ $fornecedor->cnpj }}</td>
                    <td>{{ $fornecedor->telefone }}</td>
                    <td>{{ $fornecedor->email }}</td>
                    <td>{{ $fornecedor->cidade }}/{{ $fornecedor->estado }}</td>
                    <td>
                        <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn-edit">Editar</a>
                        <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>VendaFácil &copy; {{ date('Y') }} - Sistema de Gerenciamento</p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("searchInput");
            const rows = document.querySelectorAll("tbody tr");

            searchInput.addEventListener("input", () => {
                const term = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
                    const cnpj = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
                    
                    if (name.includes(term) || cnpj.includes(term)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
</body>
</html>