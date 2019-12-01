## Laravel debugbar vscode opener

## Warning: still on development

## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require erlangparasu/laravel-debugbar-vscode --dev
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel 5.5+:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
ErlangParasu\DebugbarVscode\ServiceProvider::class,
```

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="ErlangParasu\DebugbarVscode\ServiceProvider"
```

### Lumen:

For Lumen, register a different Provider in `bootstrap/app.php`:

```php
if (env('APP_DEBUG')) {
 $app->register(ErlangParasu\DebugbarVscode\LumenServiceProvider::class);
}
```
