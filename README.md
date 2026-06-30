# Suporte Técnico

Sistema de formulário de suporte técnico feito com Laravel.

## Requisitos

- PHP 8.5+
- MariaDB / MySQL
- Composer

## Instalação

```bash
git clone <url-do-repositorio>
cd suporte-tec
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Acesse em `http://localhost:8000`

## Configuração do banco

Crie um banco MySQL e ajuste as credenciais no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_DATABASE=suporte_tec
DB_USERNAME=suporte
DB_PASSWORD=suporte123
```
