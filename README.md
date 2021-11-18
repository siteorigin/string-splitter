# Splits strings into separate words.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/siteorigin/string-splitter.svg?style=flat-square)](https://packagist.org/packages/siteorigin/string-splitter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/siteorigin/string-splitter/run-tests?label=tests)](https://github.com/siteorigin/string-splitter/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/siteorigin/string-splitter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/siteorigin/string-splitter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/siteorigin/string-splitter.svg?style=flat-square)](https://packagist.org/packages/siteorigin/string-splitter)

A very simple library for splitting strings into separate words. It uses English word frequency data to guess the most likely combinations. The algorithm is fairly slow, so this is best suited to splitting short strings like domain names.

## Installation

You can install the package via composer:

```bash
composer require siteorigin/string-splitter
```

## Usage

```php
$splitter = new SiteOrigin\StringSplitter\StringSplitter('expertsexchange');
var_dump($splitter->split()); // ['experts', 'exchange']
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Greg Priday](https://github.com/gregpriday)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
