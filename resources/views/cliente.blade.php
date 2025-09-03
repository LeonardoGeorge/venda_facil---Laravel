<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VendaFácil - Clientes</title>
    <!-- Adicionando Font Awesome para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset básico */
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
        }

        /* ===== SEARCH ===== */
        .search-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* ===== TABLE ===== */
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

        /* ===== BUTTONS ===== */
        .btn-edit {
            background-color: #7ac943;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #3b691a;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #1a1717;
            margin-top: 40px;
            color: #fff;
        }

        /* ===== MESSAGES ===== */
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
        
        /* ===== WHATSAPP ICON ===== */
        .whatsapp-link {
            color: #25D366;
            margin-left: 8px;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.2s;
        }
        
        .whatsapp-link:hover {
            transform: scale(1.2);
        }
        
        .telefone-container {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>VendaFácil - Clientes</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/cadastro">Cadastro</a>
        </nav>
    </header>

    <div class="container">
        <h2 class="page-title">Lista de Clientes</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <input type="text" id="searchInput" placeholder="Pesquisar cliente..." class="search-input">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>
                        <div class="telefone-container">
                            {{ $cliente->telefone }}
                            @if($cliente->telefone)
                                <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}" 
                                   target="_blank" 
                                   class="whatsapp-link"
                                   title="Conversar no WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                    <td>{{ $cliente->endereco }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn-edit">Editar</a>
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
                    const email = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
                    
                    if (name.includes(term) || email.includes(term)) {
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