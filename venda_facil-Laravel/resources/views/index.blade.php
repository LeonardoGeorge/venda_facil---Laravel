<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Vendas</title>
  <link rel="stylesheet" href="style.css">

<style>
    body {
  margin: 0;
  font-family: 'Arial', sans-serif;
  background: #000000;
}
a {
    text-decoration: none;
    color: inherit;
}

.top-bar {
  background: #111;
  color: white;
  padding: 15px 40px;
  flex-wrap: wrap;
  display: flex;
  justify-content: space-between;
  align-items: center;
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
  align-items: center;
}

.auth-buttons a, .auth-buttons button {
    display: inline-block;
    text-align: center;
    text-decoration: none;
    padding: 5px 15px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    font-family: inherit;
}

.btn-outline {
    background: transparent;
    color: white;
    border: 1px solid white;
}

.btn-outline:hover {
    background: white;
    color: black;
}

.btn-solid {
    background: #7ac943;
    color: black;
    border: none;
}

.btn-solid:hover {
    background: #68a836;
}

.btn-welcome {
    background: #6c757d;
    color: white;
    border: none;
    padding: 5px 12px;
}

.btn-welcome:hover {
    background: #5a6268;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #7ac943;
    font-weight: bold;
}

.section-cards {
  background: #000000;
  display:flex;
  justify-content:center;
  gap: 15px;
  padding: 30px;
}

.card {
  background: white;
  width: 280px;
  padding: 20px;
  border-radius: 8px;
  color: white;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.card h2 {
  margin-top: 0;
}

.card ul {
  list-style: none;
  padding: 0;
}

.card ul li {
  margin: 6px 0;
}

.card button {
  background: white;
  color: black;
  border: none;
  padding: 8px 12px;
  margin-top: 10px;
  cursor: pointer;
  border-radius:5px;
  font-weight: bold;
}

/* Cores dos blocos */
.yellow { background: #f0c419; }
.purple { background: #9b59b6; }
.orange { background: #f39c12; }
.blue   { background: #1abc9c; }

/* ===== FOOTER ===== */
.footer {
  text-align: center;
  padding: 15px;
  background-color: #000000;
  margin-top: 40px;
  color: #8b8b8b;
}
</style>
</head>

<body>
<header class="top-bar">
    <div class="logo"><a href="http://localhost:8000/">Venda<span>FACIL</span></a></div>
    <nav>
        <ul class="menu">
            <li><a href="http://localhost:8000/venda">Vendas</a></li>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
            <li><a href="http://localhost:8000/cliente">Clientes</a></li>
            <li><a href="http://localhost:8000/produtos">Produtos</a></li>
            <li><a href="http://localhost:8000/financeiro">Financeiro</a></li>
            <li><a href="http://localhost:8000/fornecedores">Fornecedores</a></li> 
        </ul>
    </nav>
    <div class="auth-buttons">
        @auth
            <!-- Usuário logado -->
            <div class="user-info">
                <span>Olá, {{ Auth::user()->name }}!</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline">Sair</button>
            </form>
        @else
            <!-- Visitante -->
            <a href="{{ route('login') }}" class="btn-outline">Entrar</a>
            <a href="{{ route('register') }}" class="btn-solid">Criar Conta</a>
        @endauth
    </div>
</header>

<main class="section-cards">
  <div class="card yellow">
    <h1>CADASTROS</h1>
    <ul>
      <li>✅ Cadastro de clientes</li>
      <li>✅ Cadastro de produtos</li>
      <li>✅ Cadastro de fornecedores</li>
    </ul>
    <button><a href='http://localhost:8000/cadastro'>Comece a cadastrar</a></button>
  </div>

  <div class="card purple">
    <h1>VENDAS</h1>
    <ul>
      <li>✅ Acesso à tela de venda</li>
      <li>✅ 100% grátis</li>
      <li>✅ 100% online</li>
    </ul>
    <button><a href="http://localhost:8000/venda">Comece a vender</a></button>
  </div>

  <div class="card orange">
    <h1>CLIENTE</h1>
    <ul>
      <li>✅ Relatórios</li>
      <li>✅ Informações</li>
      <li>✅ Marketing</li>
    </ul>
    <button><a href="http://localhost:8000/cliente">Comece a divulgar</button>
  </div>

  <div class="card blue">
    <h1>FINANÇAS</h1>
    <ul>
      <li>✅ Relatórios financeiros</li>
      <li>✅ Meios de pagamento</li>
      <li>✅ Fluxo de caixa</li>
    </ul>
    <button><a href="http://localhost:8000/financeiro">Comece a se organizar</button>
  </div>
</main>

<footer class="footer">
  <p>Criado por <strong>Leonardo George</strong> &copy; 2025</p>
</footer>
</body>
</html>