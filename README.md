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

- `set(string $key, mixed $value): void`
- `get(string $key, mixed $default = null): mixed`

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bhittani\Repository\Repository;

$storage = new Repository;

$storage->set('foo', 'bar');
echo $storage->get('foo'); // 'bar'

// Store an array and receive a value using dot notated key access.
$storage->set('app', ['name' => 'Acme', 'version' => '0.1.0']);
echo $storage->get('app.version'); // '0.1.0'

// Store a value using dot notated keys.
$storage->set('db.sqlite.path' => ':memory:');
$storage->set('db.sqlite.prefix' => 'acme_');
echo $storage->get('db.sqlite'); // ['path' => ':memory:', 'prefix' => 'acme_']

// Check whether a key exists.
var_dump($storage->has('bar')); // (bool) false

// Accessing a key that is not set, will return null.
echo $storage->get('bar'); // null

// Fallback to a default value if the accessed key isn't set.
echo $storage->get('bar', 'fallback'); // 'fallback'

// Preset a value if the key isn't already set.
$storage->preset('a', 'b');
echo $storage->get('a'); // 'b'

$storage->set('x', 'y');
$storage->preset('x', 'z');
echo $storage->get('x'); // 'y'
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed.

## Testing

```shell
$ git clone https://github.com/kamalkhan/repository
$ composer install
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details.

## Security

If you discover any security related issues, please email `shout@bhittani.com` instead of using the issue tracker.

## Credits

- [Kamal Khan](http://bhittani.com)
- [All Contributors][https://github.com/kamalkhan/repository/contributors]

## License

The MIT License (MIT). Please see the [License File](LICENSE.md) for more information.

<!--Status-->
[icon-status]: https://img.shields.io/travis/kamalkhan/repository.svg?style=flat-square
[link-status]: https://travis-ci.org/kamalkhan/repository
<!--Coverage-->
[icon-coverage]: https://api.codacy.com/project/badge/Coverage/<key>
[link-coverage]: https://www.codacy.com/app/kamalkhan/repository
<!--Grade-->
[icon-grade]: https://api.codacy.com/project/badge/Grade/<key>
[link-grade]: https://www.codacy.com/app/kamalkhan/repository
<!--Downloads-->
[icon-downloads]: https://img.shields.io/packagist/dt/bhittani/repository.svg?style=flat-square
[link-downloads]: https://packagist.org/packages/bhittani/repository
<!--License-->
[icon-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
<!--composer-->
[link-composer]: https://getcomposer.org
