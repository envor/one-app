# There is this one-app ... 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/envor/one-app.svg?style=flat-square)](https://packagist.org/packages/envor/one-app)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/envor/one-app/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/envor/one-app/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/envor/one-app/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/envor/one-app/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/envor/one-app.svg?style=flat-square)](https://packagist.org/packages/envor/one-app)

Database per team starter kit for Laravel based on Laravel Jetstream and Livewire

## Installation

First set up a fresh laravel app:

### Using laravel installer

```bash
laravel new one-app
```

### Or using composer

```bash
composer create-project "laravel/laravel:^11.0" one-app
```

```bash
cd one-app
```

Then you can install the package via composer:

```bash
composer require envor/one-app
```

```bash
php artisan one-app:install
```

To Configure your platform database (aka `central` or `landlord` database, etc..)

Add the following key to your `.env` file:

```ini
PLATFORM_DB_CONNECTION=sqlite
```

> [!NOTE]  
> If you use a connection other than sqlite, you will have to ensure you have configured you credentials for the connection
>

Next, freshen your migrations, using the `database/migration/platform` path, and the name of your `PLATFORM_DB_CONNECTION`

```bash
php artisan migrate:fresh --path=database/migrations/platform --database=sqlite
```

You can now test your application to ensure everything is working properly!

```bash
php artisan test
```

## SSO (Optional)

If you need it you can set up `one-app` to use `laravel/passport` instead of `laravel/sanctum` which will include a full OAuth2 Server, complete with self-service token and client management ui.

First follow the steps above to install one-app.

Next install headerx/laravel-jetstream-passport

```bash
composer require headerx/laravel-jetstream-passport:^1.0
```
> [!IMPORTANT]  
> Do not run the `jetstream-passport:install` command from [headerx/laravel-jetstream-passport](https://github.com/headerx/laravel-jetstream-passport) when setting up `one-app`! `one-app` has its own command for installing `passport` (shown below).

Then run `one-app:passport` command

```bash
php artisan one-app:passport
```

Then run migrations

```bash
php artisan migrate --path="database/migrations/platform" --database="sqlite"
```

Then run tests again!

## Testing

```bash
php artisan test
```

or

```bash
composer test
```

## Development

This thing installs stuff. During development the stubs will have to be tested. What follows are instructions for doing so.

requirements:

- php ^8.2
  - extensions
    - see https://laravel.com/docs/master/deployment#server-requirements
- composer
- basic working knowledge of git

### 1. Setup Laravel Environment in an empty directory

```bash
composer create-project laravel/laravel:11.x-dev .
composer require laravel/jetstream:@dev --no-interaction --no-update
composer require envor/one-app:@dev --no-interaction --no-update
composer config repositories.one-app '{"type": "path", "url": "one-app"}' --file composer.json
```

```bash
echo "PLATFORM_DB_CONNECTION=sqlite" >> .env
```

```bash
echo "one-app/" >> .gitignore
```

```bash
git add . && git commit -m "setup testing environment"
```

### 2. Clone the repo

SSH

```bash
git clone git@github.com:envor/one-app.git
```

HTTPS

```bash
git clone https://github.com/envor/one-app.git
```

### 3. Install dependencies (in root working directory, not one-app)

```bash
composer update "laravel/jetstream" --prefer-dist --no-interaction --no-progress -W
```

### 4. Install one-app (in root working directory, not one-app)

```bash
composer update "envor/one-app" --prefer-dist --no-interaction --no-progress -W
```

```bash
php artisan one-app:install -v
```

### 5. Install npm dependencies (in root working directory, not one-app)

```bash
npm install
```

### 6. Compile Assets (in root working directory, not one-app)

```bash
npm run build
```

### 7. Execute tests (in root working directory, not one-app)

```bash
php artisan test
```

### 8. If you are green, you are good to go. You can now reset your environment to begin making changes.

```bash
git reset --hard && git clean -df
```

```bash
composer install
```

### 9. Make your changes

Edit files in `one-app/` directory

### 10. Test your changes by repeating steps 3-7.
### 11. Repeat steps 8-10
### 12. Repeat step 11 as many times as needed.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [inmanturbo](https://github.com/envor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
