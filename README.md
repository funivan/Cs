# Code Style fix and review

[![Packagist](https://img.shields.io/packagist/v/funivan/cs.svg)](https://packagist.org/packages/funivan/cs)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/funivan/Cs/master.svg?style=flat-square)](https://travis-ci.org/funivan/Cs)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/Funivan/Cs.svg?style=flat-square)](https://scrutinizer-ci.com/g/funivan/Cs/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/funivan/Cs.svg?style=flat-square)](https://scrutinizer-ci.com/g/funivan/Cs)
[![Total Downloads](https://img.shields.io/packagist/dt/funivan/cs.svg?style=flat-square)](https://packagist.org/packages/funivan/cs)

Perform code fix and review


## Tools list

| Fixer | Review | Link                                                                             |
|:-----:|:------:|:---------------------------------------------------------------------------------|
| ✔     | ✔      | [SpacesInEmptyLines](src/Tools/SpacesInEmptyLines/README.md)                     |
| ✔     | ✔      | [PhpOpenTags](src/Tools/PhpOpenTags/README.md)                                   |
| ✔     | ✔      | [LineEnding](src/Tools/LineEnding/README.md)                                     |


## Install

Via Composer

``` bash
composer require funivan/cs:dev-master
```

## Usage

```sh
  # run review tool
  ./vendor/bin/cs.php review;

  # run fixer tool
  ./vendor/bin/cs.php fix;

```

## Custom configuration
Create custom configuration file. For example `cs-fix.php`

```php
<?
  # file cs-fix.php
  require __DIR__ . '/vendor/autoload.php';


  use Funivan\Cs\Configuration\CsConfiguration;
  use Funivan\Cs\FileFinder\FinderFactory\FileFinderFactory;

  $configuration = CsConfiguration::createFixerConfiguration();
  $configuration->setFileFinderFactory(new FileFinderFactory(__DIR__));

  // You can add custom tools
  $configuration->setTool(new \Funivan\Cs\Tools\LineEnding\LineEndingFixer());

```
Then run fixer
```sh
  ./vendor/bin/cs.php fix --configuration=cs-fixer.php -vvv
```

## Testing

``` bash
    ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/funivan/Cs/blob/master/CONTRIBUTING.md) for details.

## Credits

- [funivan](https://github.com/funivan)
- [All Contributors](https://github.com/funivan/Cs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
