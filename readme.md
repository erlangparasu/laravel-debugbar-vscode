# laravel-debugbar-vscode

Plugin **laravel-debugbar** that provide **button** to open **vscode**

This package code is based on https://github.com/barryvdh/laravel-debugbar/tree/2.4

This package is compatible with **barryvdh/laravel-debugbar:~2.4**

## How to use

Move mouse pointer to text that contains file path, then the button will appear. Click to open the path in vscode :D

![Screenshot 1](screenshots/laravel-debugbar-vscode.screnshot-1.png)
![Screenshot 2](screenshots/laravel-debugbar-vscode.screnshot-2.png)

## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require erlangparasu/laravel-debugbar-vscode:~0.2.0 --dev
```

After updating composer, add the ServiceProvider to the providers array in config/app.php

### Laravel 5.x:

```php
ErlangParasu\DebugbarVscode\ServiceProvider::class,
```

### Lumen:

For Lumen, register a different Provider in `bootstrap/app.php`:

```php
if (env('APP_DEBUG')) {
    $app->register(ErlangParasu\DebugbarVscode\LumenServiceProvider::class);
}
```
