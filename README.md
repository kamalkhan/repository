# Repository

[![Travis Build Status][icon-status]][link-status]
[![Codacy Coverage][icon-coverage]][link-coverage]
[![Codacy Grade][icon-grade]][link-grade]
[![Packagist Downloads][icon-downloads]][link-downloads]
[![License][icon-license]](LICENSE.md)

Fluent storage repository with dot notated key support.

## Install

You may install this package using [composer][link-composer].

```shell
$ composer require bhittani/repository
```

## Usage

This package provides a fluent and intuitive storage repository.

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bhittani\Repository\Repository;

$storage = new Repository;

// See below examples for usage...
```

### Store and retrieve values

```php
// Store and retrieve a value.
$storage->set('foo', 'bar');
echo $storage->get('foo'); // 'bar'

// Store an array and retrieve a value using dot notated key access.
$storage->set('app', ['name' => 'Acme', 'version' => '0.1.0']);
echo $storage->get('app.version'); // '0.1.0'

// Store a value using dot notated keys.
$storage->set('db.sqlite.path', ':memory:');
$storage->set('db.sqlite.prefix', 'acme_');
var_dump($storage->get('db.sqlite')); // ['path' => ':memory:', 'prefix' => 'acme_']
```

### Preset an undefined key

```php
$storage->preset('a', 'b');
echo $storage->get('a'); // 'b'

$storage->set('x', 'y');
$storage->preset('x', 'z');
echo $storage->get('x'); // 'y'
```

### Append a value

```php
$storage->set('append', ['foo']);
$storage->append('append', 'bar');
var_dump($storage->get('append')); // ['foo', 'bar']
```

### Prepend a value

```php
$storage->set('prepend', ['foo']);
$storage->append('prepend', 'bar');
var_dump($storage->get('prepend')); // ['bar', 'foo]
```

### Increment a value

```php
echo $storage->get('incr'); // null

$storage->increment('incr');
echo $storage->get('incr'); // 1

$storage->increment('incr', 5);
echo $storage->get('incr'); // 6
```

### Decrement a value

```php
echo $storage->get('decr'); // null

$storage->decerement('decr');
echo $storage->get('decr'); // -1

$storage->decerement('decr', 5);
echo $storage->get('decr'); // -6
```

### Fallback to a default value

```php
echo $storage->get('bar'); // null

echo $storage->get('bar', 'fallback'); // 'fallback'
```

### Check whether a key is set

```php
var_dump($storage->has('bar')); // (bool) false
```

### Get all items

```php
$storage->add('foo', 'bar');
$storage->add('beep.boop', 'baz');

var_dump($storage->all()); // ['foo' => 'bar', 'beep' => ['boop' => 'baz']]
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed.

## Testing

```shell
$ git clone https://github.com/kamalkhan/repository
$ cd repository
$ composer install
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details.

## Security

If you discover any security related issues, please email `shout@bhittani.com` instead of using the issue tracker.

## Credits

- [Kamal Khan](http://bhittani.com)
- [All Contributors](https://github.com/kamalkhan/repository/contributors)

## License

The MIT License (MIT). Please see the [License File](LICENSE.md) for more information.

<!--Status-->
[icon-status]: https://img.shields.io/travis/kamalkhan/repository.svg?style=flat-square
[link-status]: https://travis-ci.org/kamalkhan/repository
<!--Coverage-->
[icon-coverage]: https://api.codacy.com/project/badge/Coverage/ae5ab63e9eb54cd996cbd0a1efadfe58
[link-coverage]: https://www.codacy.com/app/kamalkhan/repository
<!--Grade-->
[icon-grade]: https://api.codacy.com/project/badge/Grade/ae5ab63e9eb54cd996cbd0a1efadfe58
[link-grade]: https://www.codacy.com/app/kamalkhan/repository
<!--Downloads-->
[icon-downloads]: https://img.shields.io/packagist/dt/bhittani/repository.svg?style=flat-square
[link-downloads]: https://packagist.org/packages/bhittani/repository
<!--License-->
[icon-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
<!--composer-->
[link-composer]: https://getcomposer.org
