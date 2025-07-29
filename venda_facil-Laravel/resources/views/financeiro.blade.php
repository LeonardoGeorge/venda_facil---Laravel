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

.section-cards {
  background: #000000;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  padding: 40px;
}

.card {
  background: white;
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
  margin: 10px 0;
}

.card button {
  background: white;
  color: black;
  border: none;
  padding: 8px 12px;
  margin-top: 10px;
  cursor: pointer;
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
<header class="top-bar">
    <div class="logo"><a href="01.index.html">Venda<span>FACIL</span></a></div>
    <nav>
        <ul class="menu">
            <li><a href="http://localhost:8000/venda">Vendas</a></li>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
            <li><a href="http://localhost:8000/cliente">Clientes</a></li>
            <li><a href="http://localhost:8000/produtos">Produtos</a></li>
            <li><a href="http://localhost:8000/financeiro">Financeiro</a></li>
            <li><a href="http://localhost:8000/estoque">Estoque</a></li>
        </ul>
    </nav>