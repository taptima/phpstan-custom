# [Taptima](https://taptima.ru/) customs extensions for PHPStan

[![Latest Stable Version](https://poser.pugx.org/taptima/phpstan-custom/v/stable)](https://packagist.org/packages/taptima/phpstan-custom)
[![License](https://poser.pugx.org/taptima/phpstan-custom/license)](https://packagist.org/packages/taptima/phpstan-custom)

* [PHPStan](https://phpstan.org/)

This extension provides following features:

* Validates common entity properties existence of methods `set*`, `get*`.
* Validates boolean entity properties existence of methods `set*`, `is*` or `has*`.
* Validates `ArrayCollection` entity properties existence of methods `add*`, `remove*` and `get*`.

## Installation
Open a command console, enter your project directory and execute the following command to download the latest stable version of this extension:
```bash
composer require --dev taptima/phpstan-custom dev-master
```

Then include extension.neon in your project's PHPStan config:

```neon
includes:
    - vendor/taptima/phpstan-custom/extension.neon
```

and

```neon
includes:
    - vendor/taptima/phpstan-custom/rules.neon
```

This extensions depends on [phpstan-doctrine](https://github.com/phpstan/phpstan-doctrine), so you have to configure it.

## Contribution

Before to create a pull request to submit your contributon, you must:
 - run tests and be sure nothing is broken

### How to run tests

```bash
make test
```
