<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# Sistema de Vendas - Backend

## Subindo o projeto com Laravel Sail

1. **Copie o arquivo de exemplo de ambiente:**
   ```bash
   cp .env.example .env
   ```

2. **Suba os containers com o Sail:**
   ```bash
   ./vendor/bin/sail up -d
   ```

3. **Instale as dependências do Composer (caso necessário):**
   ```bash
   ./vendor/bin/sail composer install
   ```

4. **Gere a chave da aplicação:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

5. **Rode as migrations e seeds:**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

6. **(Opcional) Crie um usuário para autenticação:**
   ```bash
   ./vendor/bin/sail artisan tinker
   >>> \\App\\Models\\User::factory()->create(['email' => 'admin@email.com', 'password' => bcrypt('password')]);
   ```

## Autenticação

Agora a autenticação é feita via endpoint de login:

### Login
```http
POST /api/login
Content-Type: application/json
{
  "email": "admin@email.com",
  "password": "password"
}
```
**Resposta:**
```json
{
  "token": "SEU_TOKEN_AQUI",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@email.com"
  }
}
```

Use o token retornado no header das requisições:
```
Authorization: Bearer SEU_TOKEN_AQUI
```

## Exemplos de uso dos endpoints

### Listar vendedores (paginado)
```http
GET /api/sellers?page=1&per_page=10
Authorization: Bearer SEU_TOKEN_AQUI
```

### Criar vendedor
```http
POST /api/sellers
Authorization: Bearer SEU_TOKEN_AQUI
Content-Type: application/json
{
  "name": "João Silva",
  "email": "joao@email.com"
}
```

### Mostrar vendedor
```http
GET /api/sellers/1
Authorization: Bearer SEU_TOKEN_AQUI
```

### Listar vendas de um vendedor
```http
GET /api/sellers/1/sales
Authorization: Bearer SEU_TOKEN_AQUI
```

### Listar vendas (paginado)
```http
GET /api/sales?page=1&per_page=10
Authorization: Bearer SEU_TOKEN_AQUI
```

### Criar venda
```http
POST /api/sales
Authorization: Bearer SEU_TOKEN_AQUI
Content-Type: application/json
{
  "seller_id": 1,
  "amount": 100.50,
  "date": "2025-06-19"
}
```

## Endpoints da API

### Listar vendedores (com filtro por nome)
```http
GET /api/sellers?name=joao&page=1&per_page=10
Authorization: Bearer SEU_TOKEN_AQUI
```
- `name` (opcional): filtra vendedores cujo nome contenha o valor informado (ex: `joao` retorna todos que tenham "joao" no nome, usando LIKE SQL).
- `page` e `per_page` funcionam normalmente para paginação.

---

- Todas as respostas seguem o padrão de API Resource do Laravel.
- Para rodar os testes:
  ```bash
  ./vendor/bin/sail artisan test
  ```

---
