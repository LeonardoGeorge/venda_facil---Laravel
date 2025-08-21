# 📦 VendaFácil

Um sistema simples e funcional para **controle de vendas, cadastros e finanças**, desenvolvido em **Laravel** com **PostgreSQL** (PgAdmin4).
Interface limpa e moderna, com páginas de **cadastro, login e dashboard** organizadas em cards coloridos.

---

## 🚀 Tecnologias Utilizadas

- [Laravel 10](https://laravel.com/)
- [PHP 8.2+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [PostgreSQL 15](https://www.postgresql.org/) + [PgAdmin4](https://www.pgadmin.org/)
- [TailwindCSS](https://tailwindcss.com/) para os estilos
- [Blade Templates](https://laravel.com/docs/10.x/blade) para renderização

---

## 📂 Estrutura do Projeto



📁 venda-facil

┣ 📂 app

┣ 📂 bootstrap

┣ 📂 config

┣ 📂 database

┣ 📂 public

┣ 📂 resources

┃ ┣ 📂 views   → Telas (login, registro, dashboard)

┣ 📂 routes

┃ ┗ web.php   → Rotas principais

┣ 📂 storage

┣ 📂 tests

┗ .env.example → Configuração inicial do ambiente


---
## ⚙️ Configuração do Ambiente

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/seu-usuario/venda-facil.git
cd venda-facil
---
2️⃣ Instalar dependências
composer install
npm install && npm run build

3️⃣ Configurar o arquivo `.env`
cp .env.example .env

Edite o `.env` e ajuste as credenciais do Postgres:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=venda_facil
DB_USERNAME=postgres
DB_PASSWORD=sua_senha

4️⃣ Gerar chave da aplicação
php artisan key:generate

5️⃣ Rodar as migrações
php artisan migrate

### 6️⃣ Rodar servidor local

<pre class="overflow-visible!" data-start="1903" data-end="1932"><div class="contain-inline-size rounded-2xl relative bg-token-sidebar-surface-primary"><div class="sticky top-9"><div class="absolute end-0 bottom-0 flex h-9 items-center pe-2"><div class="bg-token-bg-elevated-secondary text-token-text-secondary flex items-center gap-4 rounded-sm px-2 font-sans text-xs"><span class="" data-state="closed"></span></div></div></div><div class="overflow-y-auto p-4" dir="ltr"><code class="whitespace-pre! language-bash"><span><span>php artisan serve
</span></span></code></div></div></pre>

Acesse: **[http://127.0.0.1:8000



](http://127.0.0.1:8000)**

## 📊 Funcionalidades

✅ Cadastro de clientes, produtos e fornecedores

✅ Sistema de login e registro de usuários

✅ Tela de vendas 100% online e gratuita

✅ Relatórios financeiros e fluxo de caixa

✅ Dashboard moderno com cards coloridos
