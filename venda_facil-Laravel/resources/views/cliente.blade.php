<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>VendaFácil - Clientes</title>
    
    <style>
        /* Reset básico */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #020202;
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

small {
  display: block;
  margin-top: -10px;
  margin-bottom: 15px;
  font-size: 12px;
  color: #777;
}

/* ===== FOOTER ===== */
.footer {
  text-align: center;
  padding: 15px;
  background-color: #eee;
  margin-top: 40px;
  color: #555;
}


    </style>


</head>
<body>
    <header>
        <h1>Clientes</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <li><a href="http://localhost:8000/cadastro">Cadastro</a></li>
        </nav>
    </header>
    <h1>Cadastro realizado com exito!</h1>
</body>   

   

