## How to run

Dependencies:
```
PHP 7.4+
composer
Laravel 8
Behat
sqlite 3
```

- Clone the repository.
- Download the [precompiled binaries for sql lite](https://sqlite.org/download.html) 
  to be able to use the database.
  
Then run:
```
$ composer install
```

- Laravel8 is using Symfony5.
- However, Symfony5 is not compatible with the latest Mink-Extension.
  That’s why we do not reference Mink in our behat.yml (nothing breaks this way).
  Mink is used for acceptance testing: it bootstraps a browser and creates the exact 
  HTML that the Application would create. Mink provides useful built-in methods to 
  traverse and validate the created HTML.
  It is fine not to use Mink here since we do not want to create
  acceptance tests for a REST API anyway.
- Also `laracasts/behat-laravel-extension` is not compatible with Symfony5.
  That’s why we have to change `/vendor/laracasts/behat-laravel-extension/src/Context/KernelAwareInitializer:rebootKernel()` line 80 to

```
# $this->context->getSession('laravel')->getDriver()->reboot($this->kernel = $laravel->boot());
$this->kernel = $laravel->boot();
```

Run the test suite in root:
```
$ vendor/bin/behat features
```

## How to integrate Behat on your existing Laravel project

# Laravel > 8

In order to write Integration Tests with Behat on your existing Laravel 8 project,
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

Within your project root, create an `.env.behat` file, and add:
```
APP_ENV=test
DB_DATABASE=/Full/Path/To/Your/testing/database-test.db
```

# Laravel < 8

For Laravel < 8 all the required Behat packages should be compatible. 
No code changes in vendor are required and Mink can be used.

Follow the description on [https://github.com/laracasts/Behat-Laravel-Extension](https://github.com/laracasts/Behat-Laravel-Extension) 
to integrate Behat into your existing Laravel < 8 project
