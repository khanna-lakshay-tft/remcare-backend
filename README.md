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

# Patient Management System

## Introduction

This is a full-stack application built using Laravel for the backend and React for the frontend. The application manages patient data and displays various statistics on a dashboard. It also includes OAuth2 authentication using Laravel Passport.

## Features

- Patient management (CRUD operations)
- Dashboard with charts showing patient statistics
- OAuth2 authentication with Laravel Passport

## Tech Stack

- PHP Laravel
- Illuminate ORM
- React
- Chart.js

## Setup Instructions

### Prerequisites

- PHP >= 7.4
- Composer
- Node.js & npm
- Git
- MySQL or any other preferred database

### Clone the Repository

```bash
git clone https://github.com/yourusername/patient-management.git
cd patient-management
```
## Install Backend Dependencies

```bash
composer install
```

## Environment Configuration

Copy the .env.example file to .env and configure your database and other settings:

```bash
composer install
```

Edit the .env file to match your environment configuration:

```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:C88D16FRqeMq2GilxWaOjO/dWmAw+D9I/NHP5f33gSY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost
REACT_APP_URL=http://localhost:3000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=33061
DB_DATABASE=laravel-react
DB_USERNAME=root
DB_PASSWORD=secret

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```
## Generate Application Key

```bash
php artisan key:generate
```

## Run Migrations
```bash
php artisan migrate
```

## Seed the Database
```bash
php artisan db:seed
```

## Install Passport
```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
```

## Run the Application
```bash
php artisan serve
```

## API Endpoints

### Authentication
1. POST /api/login : Login API

2. POST /api/register : Register API

### Patients
1. GET /api/patients: Get all patients

2. POST /api/patients: Create a new patient

3. GET /api/patients/{id}: Get a specific patient

4. PUT /api/patients/{id}: Update a specific patient

5. DELETE /api/patients/{id}: Delete a specific patient
