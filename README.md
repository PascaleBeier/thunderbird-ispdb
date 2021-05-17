# thunderbird-ispdb

[![Latest Version on Packagist][ico-version]][link-packagist]
[![PHP Version Support][ico-php]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

> Static distribution of thundernest/autoconfig files for PHP Applications.

## What is this?

This is a static distribution of Thunderbird's ISPDB to autoconfigure Email Addresses.
The files that you are looking for reside below [dist/](dist).

This folder is kept up-to-date with GitHub Workflows, see [GitHub Workflow](.github/workflows/main.yml). Updates are released as 
Patch Releases, e.g. v1.0.1.

### Links

- https://github.com/thundernest/autoconfig
- https://autoconfig.thunderbird.net/v1.1/
- https://wiki.mozilla.org/Thunderbird:Autoconfiguration

## Install

Via Composer

``` bash
$ composer require pascalebeier/thunderbird-ispdb
```

It is highly recommended that you `--prefer-dist` on this Repository.

## Usage

### Distribution

Use the files below [dist/](dist) in your Application.

### PHP API

As of now, this Library provides a Single Interface as a shortcut to retrieve the `dist` directory:

``` php
print_r(PascaleBeier\ThunderbirdIspdb\Ispdb::DIR); 
// => "vendor/pascalebeier/thunderbird-ispdb/dist/"
```
## Credits

- [Pascale Beier][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pascalebeier/thunderbird-ispdb.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pascalebeier/thunderbird-ispdb.svg?style=flat-square
[ico-php]: https://img.shields.io/packagist/php-v/pascalebeier/thunderbird-ispdb.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pascalebeier/thunderbird-ispdb
[link-downloads]: https://packagist.org/packages/pascalebeier/thunderbird-ispdb
[link-author]: https://github.com/PascaleBeier
[link-contributors]: ../../contributors
