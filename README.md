# Laravel Algolia

![laravel-algolia](https://cloud.githubusercontent.com/assets/499192/7440612/f4c34b2e-f0bf-11e4-8cc1-b845256be3ff.png)

> An [Algolia](https://www.algolia.com/) bridge for Laravel.

```php
// Search.
$algolia->search('marty mcfly');

// Create global API keys.
$algolia->addUserKey(['search'], 300);

// Want to use the facade?
Algolia::getLogs();
```

[![Build Status](https://img.shields.io/travis/vinkla/laravel-algolia/master.svg?style=flat)](https://travis-ci.org/vinkla/laravel-algolia)
[![StyleCI](https://styleci.io/repos/32227759/shield?style=flat)](https://styleci.io/repos/32227759)
[![Coverage Status](https://img.shields.io/codecov/c/github/vinkla/laravel-algolia.svg?style=flat)](https://codecov.io/github/vinkla/laravel-algolia)
[![Latest Version](https://img.shields.io/github/release/vinkla/algolia.svg?style=flat)](https://github.com/vinkla/algolia/releases)
[![License](https://img.shields.io/packagist/l/vinkla/algolia.svg?style=flat)](https://packagist.org/packages/vinkla/algolia)

## Installation
Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
$ composer require vinkla/algolia
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Vinkla\Algolia\AlgoliaServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'Algolia' => Vinkla\Algolia\Facades\Algolia::class
```

## Configuration

Laravel Algolia requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/algolia.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

#### Default Connection Name

This option `default` is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `main`.

#### Algolia Connections

This option `connections` is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like.

## Usage

#### AlgoliaManager

This is the class of most interest. It is bound to the ioc container as `algolia` and can be accessed using the `Facades\Algolia` facade. This class implements the ManagerInterface by extending AbstractManager. The interface and abstract class are both part of [Graham Campbell's](https://github.com/GrahamCampbell) [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at that repository. Note that the connection class returned will always be an instance of `AlgoliaSearch\Client`.

#### Facades\Algolia

This facade will dynamically pass static method calls to the `algolia` object in the ioc container which by default is the `AlgoliaManager` class.

#### AlgoliaServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

### Examples
Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
// You can alias this in config/app.php.
use Jsefton\Algolia\Facades\Algolia;

Algolia::initIndex('contacts');
// We're done here - how easy was that, it just works!

Algolia::getLogs();
// This example is simple and there are far more methods available.
```

The Algolia manager will behave like it is a `AlgoliaSearch\Client`. If you want to call specific connections, you can do that with the connection method:

```php
use Jsefton\Algolia\Facades\Algolia;

// Writing this…
Algolia::connection('main')->initIndex('contacts');

// …is identical to writing this
Algolia::initIndex('contacts');

// and is also identical to writing this.
Algolia::connection()->initIndex('contacts');

// This is because the main connection is configured to be the default.
Algolia::getDefaultConnection(); // This will return main.

// We can change the default connection.
Algolia::setDefaultConnection('alternative'); // The default is now alternative.
```

If you prefer to use dependency injection over facades like me, then you can inject the manager:

```php
use Jsefton\Algolia\AlgoliaManager;

class Foo
{
	protected $algolia;

	public function __construct(AlgoliaManager $algolia)
	{
		$this->algolia = $algolia;
	}

	public function bar()
	{
		$this->algolia->initIndex('friends');
	}
}

App::make('Foo')->bar();
```

## Documentation

There are other classes in this package that are not documented here. This is because the package is a Laravel wrapper of [the official Algolia Search API package](https://github.com/algolia/algoliasearch-client-php).

## License

[MIT](LICENSE) © [Vincent Klaiber](https://vinkla.com)
