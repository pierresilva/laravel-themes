Pierre Silva Themes
==================
pierresilva Themes gives the means to group together a set of views and assets for Laravel 5.1 and 5.2. This gives an easy way to further decouple the way your web application looks from your code base.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code. At the moment the package is not unit tested, but is planned to be covered later down the road.

Features
--------
- Supports pierresilva Modules
- Supports both the Blade and Twig templating engines
- Intelligent fallback view support
- Child/parent theme inheritance
- Theme components, easily create re-usable UI components

Documentation
-------------
You will find user friendly and updated documentation in the wiki here: [pierresilva Themes Wiki](https://github.com/pierresilva/themes/wiki)

Quick Installation
------------------
Begin by installing the package through Composer.

```
composer require pierresilva/themes
```

Once this operation is complete, simply add both the service provider and facade classes to your project's `config/app.php` file:

#### Service Provider
```php
pierresilva\Themes\ThemesServiceProvider::class,
```

#### Facade
```php
'Theme' => pierresilva\Themes\Facades\Theme::class,
```

And that's it! With your coffee in reach, start building some awesome themes!
