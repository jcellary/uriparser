
## About 

This is a simple service which allows for parsing Uris. It's implemented in PHP and is based on the Laravel framework.

## Structure

The project structure follows the standard Laravel pattern.

The UriParser Helper is the actual class performing the parsing. You can find unit tests for it in the tests/Unit folder.

The UriController is the Rest Api wrapper of the helper class. You can find integration tests for it in the tests/Feature folder.

## Running the service

As first step you need to follow instructions on Laravel home page https://laravel.com/docs/5.4 to install all dependencies required by the framework

Once that's done you can clone this repository and inside run `composer install`, which will install project specific dependencies.

You can now start the local dev server `php artisan serve`.

To use the API you can enter `curl localhost:8000/api/uri?uri=http://domain.com?query` or `curl --data "uri=http://domain.com?query" localhost:8000/api/uri`

## Testing
After following all steps described in "Running the service" you should be able to run the available test suite. To do that enter `vendor/bin/phpunit` 
