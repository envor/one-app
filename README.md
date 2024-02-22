# This is my package one-app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/envor/one-app.svg?style=flat-square)](https://packagist.org/packages/envor/one-app)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/envor/one-app/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/envor/one-app/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/envor/one-app/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/envor/one-app/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/envor/one-app.svg?style=flat-square)](https://packagist.org/packages/envor/one-app)

steps
create repo

```bash
laravel new one-app --stack=livewire --pest --jet --teams --dark --api --dev --github="--public
```

```bash
cd one-app
```


set up package build dir

```bash
mkdir dev-package
```

```bash
cd dev-package
```

setup package skeleton

```bash
gh repo create envor/one-app --template spatie/package-skeleton-laravel --clone --private
```


```bash
cd one-app
```

```bash
cd php ./configure.php
```

```bash
composer require inmanturbo/turbohx envor/laravel-datastore livewire/volt
```

```bash
cd ..
cd ..
```

```bash
composer require inmanturbo/turbohx envor/laravel-datastore livewire/volt
```

checkout a new branch

```bash
git checkout -b dev-package
```

hack hack hack


## Installation

You can install the package via composer:

```bash
composer require envor/one-app
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="one-app-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="one-app-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="one-app-views"
```

## Usage

```php
$oneApp = new Envor\OneApp();
echo $oneApp->echoPhrase('Hello, Envor!');
```

## Testing

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
