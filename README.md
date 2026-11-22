# Debug
ByTIC Debug component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bytic/debug.svg?style=flat-square)](https://packagist.org/packages/bytic/debug)
[![Latest Stable Version](https://poser.pugx.org/bytic/debug/v/stable)](https://packagist.org/packages/bytic/debug)
[![Latest Unstable Version](https://poser.pugx.org/bytic/debug/v/unstable)](https://packagist.org/packages/bytic/debug)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Tests](https://github.com/bytic/debug/actions/workflows/tests.yml/badge.svg)](https://github.com/bytic/debug/actions/workflows/tests.yml)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd/mini.png)](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd)
[![Quality Score](https://img.shields.io/scrutinizer/g/bytic/debug.svg?style=flat-square)](https://scrutinizer-ci.com/g/bytic/debug)
[![StyleCI](https://styleci.io/repos/119902214/shield?branch=master)](https://styleci.io/repos/119902214)
[![Total Downloads](https://img.shields.io/packagist/dt/bytic/debug.svg?style=flat-square)](https://packagist.org/packages/bytic/debug)

## Installation and compatibility

```bash
composer require bytic/debug
```

The package keeps PHP 8.0 as its minimum and supports `symfony/error-handler`
5.x, 6.x, 7.x and 8.x. Composer selects a version compatible with your PHP
runtime and other dependencies:

| Symfony | Minimum PHP |
| --- | --- |
| 5.x | 8.0 (this package's minimum) |
| 6.x | 8.1 |
| 7.x | 8.2 |
| 8.x | 8.4 |

Other dependencies may impose a higher PHP minimum; for example, recent ByTIC
Container releases require PHP 8.1, while PHP 8.0 uses an older compatible
2.x release.

## Existing ByTIC integration

Continue registering `Nip\Debug\DebugServiceProvider` as before. The shared
`debug` and `error-handler` services are also available through both the
`Nip\Debug` and `Symfony\Component\ErrorHandler` class names. The provider's
`boot()` method installs the shared error handler.

`Nip\Debug\Debug` and `Nip\Debug\ErrorHandler` remain Symfony subclasses.
Existing static calls, subclasses and renderable exceptions are unchanged.
When a Symfony handler is already registered, the ByTIC provider continues
reusing it rather than replacing it during service registration.

## Symfony-style integration

For new code, prefer Symfony class names in constructor type hints. An optional
PHP service configuration supports Symfony DependencyInjection 5.3 through 8:

```bash
composer require symfony/dependency-injection symfony/config
```

Import it from a Symfony application's `config/services.php`:

```php
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->import('../vendor/bytic/debug/src/Resources/config/services.php');
};
```

The class-based services are private and available for autowiring; the legacy
`debug` and `error-handler` aliases are public. All aliases resolve to shared
instances. Importing or resolving services does **not** install global PHP
handlers. In a standalone application, install the handler explicitly during
bootstrap:

```php
use Symfony\Component\ErrorHandler\ErrorHandler;

ErrorHandler::register($container->get('error-handler'));
```

In a full Symfony application, let the framework manage its own debug bootstrap;
do not import this configuration if you already have equivalent services.
This opt-in integration lays the groundwork for Symfony-style dependency
injection without requiring a bundle or replacing the ByTIC provider.

## Development

```bash
composer install
composer test
```

GitHub Actions exercises PHP 8.0 through 8.5 and Symfony 5.4, 6.4, 7.x and 8.x.
