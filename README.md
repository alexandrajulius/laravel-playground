## Specification

This repository implements a simple Rest API in Laravel that allows to query various authors and some of their quotes.
The API can respond to GET, POST and UPDATE and does not handle user authentication.

### Acceptance Criteria

- The API can provide a list of authors (`/api/authors`).
- For each author the API provides a list of quotes (`/api/quotes/<authorname>`).
- A quote can be added for an author (`/api/add-quote/<authorname>/<quote>/<bookname>`).
- An authors name and origin can be edited (`/api/author/update/<authorname>`). 

Find all possible routes that this API can handle in [/routes/api.php](https://github.com/alexandrajulius/laravel-playground/blob/main/routes/api.php).

## How to run

Dependencies:
```
PHP 7.4+
composer
Laravel 8
Behat
sqlite 3
```

Clone the repository, then run:
```
$ composer install
```
Start a server on your local with
```
$ php artisan serve
```
This command will provide the url that your server listens to (e.g. `http://127.0.0.1:8001`).
In your browser go to the specified url and query all authors that are available in the database with 
`http://127.0.0.1:8001/api/authors`:

<img width="416" alt="authors_query" src="https://user-images.githubusercontent.com/23189414/111040476-62293b80-8433-11eb-8310-7d7dcd88c024.png">

Or query all quotes that are available for Leo Tolstoy:

<img width="791" alt="tolstoy_quotes" src="https://user-images.githubusercontent.com/23189414/111041185-6e16fc80-8437-11eb-8423-d1b214b8ab2a.png">

## Database

In order to use sqlite, download the [precompiled binaries for sql lite](https://sqlite.org/download.html).

Then in the root directory of your project type
```
$ sqlite3 laravel.db
```
This enables you to access the database. 
Find the tables `authors` and `quotations` and query their content:

<img width="676" alt="authors_table" src="https://user-images.githubusercontent.com/23189414/111040317-be3f9000-8432-11eb-9432-00775c00c9d5.png">
<img width="925" alt="quotations_table" src="https://user-images.githubusercontent.com/23189414/111040362-f8a92d00-8432-11eb-8014-acff38341c83.png">

## How to run the tests

Run the test suite in your root directory:
```
$ vendor/bin/behat features
```

<img width="1042" alt="authors_feature" src="https://user-images.githubusercontent.com/23189414/111040439-373ee780-8433-11eb-92e4-c82c2dd98fa8.png">
<img width="880" alt="quotations_feature" src="https://user-images.githubusercontent.com/23189414/111040454-49208a80-8433-11eb-9cb4-d2b1960d688c.png">

## How to integrate Behat on your existing Laravel project

### Laravel > 8

In order to write Integration Tests with Behat on your existing Laravel 8 project,
install the following packages and initialize Behat:

```
$ composer require behat/behat --dev
$ composer require behat/mink --dev --with-all-dependencies
$ composer require behat/mink-extension --dev --with-all-dependencies
$ composer require laracasts/behat-laravel-extension —-dev
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

- Laravel8 is using Symfony5.
- However, the latest Mink-Extension is not yet compatible with Symfony5.
  That’s why we do not reference Mink in our behat.yml (nothing breaks this way).
  Mink is used for acceptance testing: it bootstraps a browser and creates the exact
  HTML that the Application would create. Mink provides useful built-in methods to
  traverse and validate the created HTML.
  It is fine not to use Mink here since we do not want to create
  acceptance tests for a REST API anyway.
- Also `laracasts/behat-laravel-extension` is not yet compatible with Symfony5.
  That’s why we have to change `/vendor/laracasts/behat-laravel-extension/src/Context/KernelAwareInitializer:rebootKernel()` line 80 to

```
# $this->context->getSession('laravel')->getDriver()->reboot($this->kernel = $laravel->boot());
$this->kernel = $laravel->boot();
```

### Laravel < 8

For Laravel < 8 all the required Behat packages should be compatible. 
No code changes in `vendor` are required and Mink can be used.

Follow the description on [https://github.com/laracasts/Behat-Laravel-Extension](https://github.com/laracasts/Behat-Laravel-Extension) 
to integrate Behat into your existing Laravel < 8 project
