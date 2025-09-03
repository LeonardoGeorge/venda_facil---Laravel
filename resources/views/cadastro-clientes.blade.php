 <!DOCTYPE html>
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
        <h1>Cadastro de Clientes</h1>
        <nav>
            <a href="http://localhost:8000/">Início</a>
            <a href="http://localhost:8000/venda">Vendas</a>
            <a href="http://localhost:8000/produtos">Produtos</a>
        </nav>
    </header>
 
 
 <main>
        <section>
            <h2>Dados do Cliente</h2>
            @if (session('success'))
              <p style="color: green;">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
              <div style="color: red; margin-bottom: 10px;">
                <ul>
                  @foreach ($errors->all() as $erro)
                      <li>{{ $erro }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <form method="POST" action="{{ route('cadastro.clientes.store') }}" >
                @csrf
              <label>Nome:</label>
              <input type="text" name="nome" required>
               <label>Telefone</label>
              <input type="text" name="telefone" required>
              <label>Email:</label>
              <input type="email" name="email">
              <label>CPF:</label>
              <input type="text" name="cpf" id="cpf" maxlength="14" required oninput="formatarCPF(this)">
              <small style="color: #888;">Formato: 000.000.000-00</small>
              <button type="submit">Cadastrar</button>
            </form>
        </section>
    </main>
</body>
<script>
    function formatarCPF(campo) {
        let cpf = campo.value.replace(/\D/g, '');
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
        cpf = cpf.replace(/(\d{3})(\d{2})$/, '$1-$2');
        campo.value = cpf;
    }
</script>
</html>