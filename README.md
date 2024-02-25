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
laravel new one-app --dev
```

### Or using composer

```bash
composer create project "laravel/laravel:11.x-dev" one-app
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

If you need it you can set up `one-app` to use `laravel/passport` instead of `laravel/sanctum` which will include a full OAuth2 Server, complete with self a token and client management ui.

Install headerx/laravel-jetstream-passport

```bash
composer require headerx/laravel-jetstream-passport:^1.0
```

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
