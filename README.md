# Blog Pessoal em Laravel

Blog desenvolvido em **Laravel 10** com autenticação, gestão de posts e comentários, upload de imagens/arquivos e painel administrativo para usuários autorizados.  
Projeto ideal para demonstrar conhecimentos práticos em **PHP/Laravel**, arquitetura MVC e boas práticas de desenvolvimento web.

---

## ✨ Funcionalidades

- Autenticação (login e logout)
- Cadastro e gerenciamento de usuários (rotas protegidas)
- CRUD completo de posts
- Upload de:
  - Thumbnail (capa do post)
  - Imagem do post
  - Arquivos anexos
- Comentários por visitantes e usuários autenticados
- Contador de visualizações por post
- Busca de posts por título e conteúdo
- Painel administrativo com controle de acesso

---

## 🧰 Tecnologias Utilizadas

- PHP ^8.1
- Laravel ^10
- MySQL / MariaDB
- Node.js + NPM
- Vite
- Blade (Template Engine)
- TinyMCE (Editor de texto)
- Composer

---

## ✅ Requisitos do Sistema

Antes de iniciar, certifique-se de ter instalado:

- PHP 8.1 ou superior
- Composer
- Node.js 18+ e NPM
- MySQL ou MariaDB
- Extensões PHP:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - Fileinfo

---

## 🚀 Instalação (Passo a Passo)

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/JonathanTeixeira09/Blog_pessoal_em_Laravel.git
cd Blog_pessoal_em_Laravel
```

### 2️⃣ Instalar dependências do backend
```bash
composer install
```

### 3️⃣ Criar e configurar o arquivo .env
```bash
cp .env.example .env
```

Configure o banco de dados no arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Gerar a chave da aplicação
```bash
php artisan key:generate
```

### 5️⃣ Executar as migrations
```bash
php artisan migrate
```

> Caso existam seeders:
```bash
php artisan db:seed
```

### 6️⃣ Criar link simbólico para uploads
```bash
php artisan storage:link
```

### 7️⃣ Instalar dependências do frontend
```bash
npm install
```

### 8️⃣ Compilar os assets
```bash
npm run dev
```

### 9️⃣ Subir o servidor
```bash
php artisan serve
```

Acesse no navegador:
```
http://127.0.0.1:8000
```

---

## 🔐 Acesso Administrativo

- O sistema possui rotas protegidas por autenticação.
- Para criar um administrador:
  - Crie um usuário normalmente
  - No banco de dados, altere o campo `is_admin` para `1`

> Sugestão: criar um **DatabaseSeeder** com usuário admin para ambiente local.

---

## 🗂 Estrutura do Projeto (Resumo)

```
app/
 ├── Http/
 │   └── Controllers/
 ├── Models/
routes/
 └── web.php
resources/
 └── views/
storage/
public/
```

---

## 🧪 Testes (Opcional)

```bash
php artisan test
```

---

## 📦 Build para Produção

```bash
npm run build
```

---


## 📌 Próximas Melhorias (Roadmap)

- Slug automático e único para posts
- Policies e Gates para controle de permissões
- Form Requests para validações
- API REST
- Testes automatizados
- Sistema de categorias/tags

---

## 📄 Licença

Este projeto está sob a licença MIT.

---

## 👨‍💻 Autor

**Jonathan Teixeira**  
Desenvolvedor Web | PHP | Laravel  

🔗 GitHub: https://github.com/JonathanTeixeira09  
🔗 LinkedIn: [(https://www.linkedin.com/in/jonathan-teixeira-636b3475/)]