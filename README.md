## About Behat on Laravel8

In order to write Integration Tests with Behat on Laravel 8 install 
the following packages and initialize Behat:

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
  That’s why we do not reference Mink in behat.yml (nothing breaks this way)
  It is fine not to use Mink here since we do not want to create 
  acceptance tests for a REST API anyway.
- Also `laracasts/behat-laravel-extension` is not compatible with Symfony5. 
  That’s why we have to change `/vendor/laracasts/behat-laravel-extension/src/Context/KernelAwareInitializer:rebootKernel()` to
````
# we do not need mink, that is why we do not need the driver
#$this->context->getSession('laravel')->getDriver()->reboot($this->kernel = $laravel->boot());
$this->kernel = $laravel->boot();
``
