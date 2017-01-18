Laravel Themes
==================
Laravel Themes gives the means to group together a set of views and assets for Laravel 5.3.

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

Publishing The Config File
--------------------------
```php
php artisan vendor:publish
```
This will copy the bundled config file to config/laravel-themes.php

Configuration Options
---------------------
#### Default Active Theme
Define the default active theme.
```php
'active' => 'default'
```

Folder Structure
----------------
Generating forlder structure from command line.
```php
php artisan generate:theme themeslug
```
And fallow the instructions.

Manifest File
-------------
Each theme must come supplied with a manifest file (theme.json) stored at the root of the theme, which defines supplemental details about the theme.
```json
{
    "slug": "default",
    "name": "Default",
    "author": "John Doe",
    "description": "This is an example theme.",
    "version": "1.0"
}
```

#### Get Manifest Properties
```php
echo Theme::getProperty('theme::property_key', 'default value if nothing is returned');
```

#### Set Manifest Properties
```php
Theme::setProperty('theme::property_key', 'new value to be set');
```

Setting The Active Themes
-------------------------
#### Using The Config File
#### config/laravel-themes.php
```php
...

    'active' => 'foobar'

...
```

#### Setting During Run-Time
#### app/Http/Controllers/Controller.php
```php
use Theme;

...

public function __construct()
{
    Theme::setActive('foobar');
}

...
```

Facade Reference
----------------
#### Themes

### Theme::all()
Get  all themes.
#### Returns
Collection
#### Example
```php
$themes = Theme::all();
```

### Theme::setActive($theme)
Sets the active theme that will be used to retrieve view files from.

#### Parameters
$theme (string) Theme slug. Required
#### Returns
null
#### Example
```php
Theme::setActive('bootstrap-theme');
```

### Theme::getActive()
Returns the currently active theme. 

#### Returns
string
#### Example
```php
$activeTheme = Theme::getActive();
```

### Theme::view($view, $data)
Renders the defined view. This will first check if the currently active theme has the requested view file; if not, it will fallback to loading the view file from the default view directory supplied by Laravel. 

#### Parameters
$view (string) Relative path to view file. Required
$data (mixed) Any additional data you'd like to pass along to the view file to be displayed.
#### Returns
View
#### Example
```php
$foo = 'bar';

return Theme::view('welcome', compact('foo'));
```

### Theme::response($view, $data, $status, $headers)
Rendered the defined view in the same manner that Theme::view() does, but allows the means to set a custom status response and header for the rendered page.

#### Parameters
$view (string) Relative path to view file. Required
$data (mixed) Any additional data you'd like to pass along to the view file to be displayed.
$status (integer) HTTP status code.
$header (array) HTTP headers.
#### Returns
Response
#### Example
```php
$posts = Post::orderBy('published', 'desc')->get();

return Theme::response('blog.rss', compact('posts'), 200, [
    'Content-Type' => 'application/atom+xml; charset=UTF-8'
]);
```

## Start building some awesome themes!

## Author

[Pierre Silva](http://www.lab3studio.com)