## How to run

Dependencies:
```
PHP 7.4+
composer
Laravel 8
Behat
sqlite
```
Clone the repository, download the precompiled binaries for sql lite 

$ composer install




## How to integrate Behat on Laravel 8

In order to write Integration Tests with Behat on your existing Laravel project,
install the following packages and initialize Behat:

```
$ composer require behat/behat
$ composer require behat/mink --dev --with-all-dependencies
$ composer require behat/mink-extension --dev --with-all-dependencies
$ composer require laracasts/behat-laravel-extension —dev
$ vendor/bin/behat --init
```

Next, within your project root, create a `behat.yml` file, and add:
```
default:
  extensions:
    Laracasts\Behat:
  suites:
    default:
      contexts:
        - Path\To\Your\FirstContext
        - Path\To\Your\SecondContext

```

Within your project root, create a `.env.behat` file, and add:
```
APP_ENV=test
DB_DATABASE=/Full/Path/To/Your/testing/database-test.db
```

## Note on installation

- Laravel8 is using Symfony5.
- However, Symfony5 is not compatible with the latest Mink-Extension.
  That’s why we do not reference Mink in our behat.yml (nothing breaks this way).
  Mink is a package that bootstraps a browser and creates HTML that the Application
  would create. Mink provides useful built-in methods to traverse and validate the given HTML.
  It is fine not to use Mink here since we do not want to create 
  acceptance tests for a REST API anyway.
- Also `laracasts/behat-laravel-extension` is not compatible with Symfony5. 
  That’s why we have to change `/vendor/laracasts/behat-laravel-extension/src/Context/KernelAwareInitializer:rebootKernel()` to

```
# $this->context->getSession('laravel')->getDriver()->reboot($this->kernel = $laravel->boot());
$this->kernel = $laravel->boot();
```

- For Laravel < 8 all the above packages should be compatible.
