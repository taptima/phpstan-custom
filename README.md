# [Taptima](https://taptima.ru/) customs extensions for PHPStan

* [PHPStan](https://github.com/phpstan/phpstan)

This extension provides following features:

* Validates common entity properties existence of methods `set*`, `get*`.
* Validates boolean entity properties existence of methods `set*`, `is*` or `has*`.
* Validates `ArrayCollection` entity properties existence of methods `add*`, `remove*` and `get*`.

## Installation
Open a command console, enter your project directory and execute the following command to download the latest stable version of this extension:
```bash
composer require --dev taptima/phpstan-custom
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
