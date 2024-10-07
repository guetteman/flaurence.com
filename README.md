# Flaurence

Flow automation for the web with LLMs.

## Setup

Init the project with Laravel Herd:
```shell
herd init
```

Install the dependencies:
```shell
composer install
```
```shell
nvm use
npm ci
```

Create a `.env` file:
```shell
cp .env.example .env
```

Set `OPEN_AI_API_KEY` and `FIRECRAWL_API_KEY` keys.

## Development
Migrate the database and run DevelopmentSeeder
```shell
php artisan migrate && php artisan db:seed DevelopmentSeeder
```

This will create an admin user:
- email: `user@flaurence.test`
- password: `password`

## Testing
Run tests:
```shell
herd php artisan test --parallel
```

Run mutation tests:
```shell
herd coverage ./vendor/bin/pest --mutate --parallel
```

Pint and PHPStan:
```shell
herd composer format && herd composer static-analysis
```

Debug jobs with xdebug:
```shell
herd debug artisan queue:work
```

