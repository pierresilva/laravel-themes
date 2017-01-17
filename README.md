Laravel Themes
==================
Laravel Themes gives the means to group together a set of views and assets for Laravel 5.3.

This gives an easy way to further decouple the way your web application looks from your code base.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

At the moment the package is not unit tested, but is planned to be covered later down the road.

Features
--------
- Supports pierresilva Modules
- Supports both the Blade and Twig templating engines
- Intelligent fallback view support
- Child/parent theme inheritance
- Theme components, easily create re-usable UI components

Quick Installation
------------------
Begin by installing the package through Composer.

```
composer require pierresilva/laravel-themes
```

Once this operation is complete, simply add both the service provider and facade classes to your project's `config/app.php` file:

#### Service Provider
```php
pierresilva\LaravelThemes\LaravelThemesServiceProvider::class,
```

#### Facade
```php
'Theme' => pierresilva\LaravelThemes\Facades\LaravelTheme::class,
```

## Start building some awesome themes!

## Author

[Pierre Silva](http://www.lab3studio.com)