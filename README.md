# Taptima customs extensions for PHPStan

* [PHPStan](https://github.com/phpstan/phpstan)

This extension provides following features:


* Validates common entity properties for existing methods `set*`, `get*`.
* Validates boolean entity properties for existing methods `set*`, `is*` or `has*`.
* Validates `ArrayCollection` entity properties for existing methods `add*`, `remove*` and `get*`.

## Installation

Before you make `composer require` in your project, you must specify the path to the repository.
To do this, add the lines in the composer.json file:
```
"repositories": [
  {
    "type": "git",
    "url": "git@gitlab.fac.im:taptima/phpstan-custom.git"
  }
]
```

After that do `composer require taptima/phpstan-custom`.
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

