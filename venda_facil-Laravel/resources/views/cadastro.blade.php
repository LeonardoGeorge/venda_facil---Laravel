<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros - Venda Fácil</title>
    <style>
        /* CSS Reset e Estilos Globais */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        a {
    text-decoration: none;
    color: inherit; /* Herda a cor do elemento pai */
}
.top-bar {
  background: #111;
  color: white;
  padding: 15px 40px;
  flex-wrap: wrap;
  display: flex;
  justify-content: space-between;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  color: #fff;
}

.logo span {
  background: #7ac943;
  color: #181818;
  padding: 2px 6px;
  border-radius: 3px;
  margin-left: 4px;
}

.menu {
  list-style: none;
  display: flex;
  gap: 20px;
  padding: 0;
  margin: 0;
}

.menu li a {
  color: rgb(250, 234, 234);
  text-decoration: none;
  font-size: 16px;
}

.menu li a:hover {
  color: #7ac943;
}

.auth-buttons {
  display: flex;
  gap: 10px;
}

.btn-outline {
  background: transparent;
  color: white;
  border: 1px solid white;
  padding: 5px 15px;
  cursor: pointer;
}

.btn-solid {
  background: #7ac943;
  color: black;
  border: none;
  padding: 5px 15px;
  cursor: pointer;
}

        body {
            background-color: #000000;
            color: #333;
            line-height: 1.6;
            
        }
        
        /* Container Principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        /* Cabeçalho */
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 2.2rem;
            border-bottom: 2px solid #7ac943;
            padding-bottom: 10px;
        }
        
        /* Seções */
        section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #7ac943;
        }
        
        h2 {
            color: #7ac943;
            margin-bottom: 15px;
        }
        
        ul {
            list-style-position: inside;
            margin-bottom: 15px;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        /* Destaques */
        .highlight {
            font-weight: bold;
            color: #e74c3c;
            font-style: italic;
        }
        
        /* Rodapé */
        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #4a4f50;
            font-size: 0.9rem;
        }
        
        /* Botões/Links de Ação */
        .action-button {
            display: inline-block;
            background: #7ac943;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }
        
        .action-button:hover {
            background: #416e21;
        }
    </style>
</head>
<header class="top-bar">
    <div class="logo"><a href="http://localhost:8000/">Venda<span>FACIL</span></a></div>
    <nav>
        <ul class="menu">
            <li><a href="http://localhost:8000/venda">Vendas</a></li>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
            <li><a href="http://localhost:8000/cliente">Clientes</a></li>
            <li><a href="http://localhost:8000/produtos">Produtos</a></li>
            <li><a href="http://localhost:8000/finaceiro">Financeiro</a></li>
            <li><a href="http://localhost:8000/estoque">Estoque</a></li>
        </ul>
    </nav>
   
</header>


<body>
    

    <div class="container">
        <h1>CADASTROS</h1>
        
        <section>
            <h1>Clientes</h1>
            <a href="http://localhost:8000/cadastro-clientes" class="action-button">Comece a cadastrar</a>
            
        </section>
        <section>
            <h1>Produtos</h1>
            <a href="http://localhost:8000/cadastro-produtos" class="action-button">Comece a cadastrar</a>
        </section>
        <section>
            <h1>Fornecedores</h1>
            <a href="http://localhost:8000/cadastro-fornecedor" class="action-button">Comece a cadastrar</a>
        </section>
        
        <footer>
            Criado por Leonardo George © 2025
        </footer>
    </div>
</body>
</html>