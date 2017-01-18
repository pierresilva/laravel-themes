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

#### Theme::all()
Get  all themes.
##### Returns
Collection
##### Example
```php
$themes = Theme::all();
```

#### Theme::setActive($theme)
Sets the active theme that will be used to retrieve view files from.

##### Parameters
$theme (string) Theme slug. Required
##### Returns
null
##### Example
```php
Theme::setActive('bootstrap-theme');
```

#### Theme::getActive()
Returns the currently active theme. 

##### Returns
string
##### Example
```php
$activeTheme = Theme::getActive();
```

#### Theme::view($view, $data)
Renders the defined view. This will first check if the currently active theme has the requested view file; if not, it will fallback to loading the view file from the default view directory supplied by Laravel. 

##### Parameters
$view (string) Relative path to view file. Required
$data (mixed) Any additional data you'd like to pass along to the view file to be displayed.
##### Returns
View
##### Example
```php
$foo = 'bar';

return Theme::view('welcome', compact('foo'));
```

#### Theme::response($view, $data, $status, $headers)
Rendered the defined view in the same manner that Theme::view() does, but allows the means to set a custom status response and header for the rendered page.

##### Parameters
$view (string) Relative path to view file. Required
$data (mixed) Any additional data you'd like to pass along to the view file to be displayed.
$status (integer) HTTP status code.
$header (array) HTTP headers.
##### Returns
Response
##### Example
```php
$posts = Post::orderBy('published', 'desc')->get();

return Theme::response('blog.rss', compact('posts'), 200, [
    'Content-Type' => 'application/atom+xml; charset=UTF-8'
]);
```

## Start building some awesome themes!
Let's say we have bootstrap theme in our application with the following structure:
````
public/
    |-- themes/
        |-- bootstrap/
            |-- theme.json   <--- theme manifest file
            |-- assets/
                |-- css/
                    |-- bootstrap.css
                |-- img/
                |-- js/
                    |-- bootstrap.js
                    |-- jquery.js
            |-- views/
                |-- layout.blade.php     <--- this is our view layout
                |-- auth/
                    |-- login.blade.php  <--- this is our login view
````

First, we need **theme.json** manifest file.

```json
{
    "slug": "bootstrap",
    "name": "Bootstrap",
    "author": "Jhon Doe",
    "description": "Bootstrap theme.",
    "version": "1.0.0"
}
```

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bootstrap Theme Sample</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ Theme::asset('bootstrap::css/bootstrap.css') }}" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            @yield('content')
        </div>

        <script src="{{ Theme::asset('bootstrap::js/jquery.js') }}"></script>
        <script src="{{ Theme::asset('bootstrap::js/bootstrap.js') }}"></script>
    </body>
</html>
```

Please take note that we need to use **Theme::asset()** to load our theme asset files. The bootstrap is a theme slug defined in our **theme.json** file.

In our controller, load the view using the following code:

```php
public function getLogin()
{
    return Theme::view('auth.login');
}
```

Now, for our login.blade.php:

```php
@extends('bootstrap::layout')

@section('content')
    <h1>Log In</h1>

    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            Password
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember"> Remember Me
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>
@endsection
```

Note that we are using **@extends('bootstrap::layout')** in our login view, where bootstrap is a theme slug defined in our theme.json and layout is our layout file.

## Author
Inspired in [Caffeinated Themes](https://github.com/caffeinated/themes)

[Pierre Silva](http://www.lab3studio.com)