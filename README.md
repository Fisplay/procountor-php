# procountor-php

First and foremost, this repository is a fork of https://github.com/Fisplay/procountor-php and not compatible with the original one (and still under active development, no stable version yet). I'm still using most of the underlying resources, but everything around them is largely rewritten.


## Credits

Credit where credit is due, this project is based on other people's hard work. See the [original repositroy here](https://github.com/Fisplay/procountor-php).


## What's chamged?

- No more hard dependencies. Loggers, HTTP clients, you name it, all injected & easily replaced.
- Modernized test suite (uses [Pest](https://pestphp.com/))
- PHP8 compatibility
- Code is documented with phpdoc instead of generic comments (still WIP)
- PSR compatible;
    - PSR-3 logger interfaces
    - PSR-6 cache interfaces
    - PSR-7 HTTP Message interfaces
    - PSR-17 HTTP Factories
    - PSR-18 HTTP Clients
- Laravel compatible (can be installed as a Laravel package)
    - [x] ServiceProvider to register client
    - [ ] ServiceProvider to register resources (parital)
    - [x] Config
    - [ ] Facades for resources (partial)
    - [ ] Helper for authorization flow (partial)
    - [ ] Jobs for create -operations


## Tested working API's

- Invoices
    - Create invoice
    - List invoices


## TODO

- Check each resource against current Procountor API
- Export documentation to static site
- Write facades
- Finalize authorization flow (view?)


## About Guzzle HTTP client

This library relies on PSR spec which explicitly prohibits HTTP Client library from throwing on HTTP 4XX/5XX response code ranges.
GuzzleHttp by default throws their own BadResponseException on HTTP 4XX/5XX responses, so make sure to set http_errors config parameter to false before injection.


## Usage

As one of the main golas was to increase flexibility & testability by leveraging DI, I higly suggest that you use this project only if you are already using [DI containers](https://www.php-fig.org/psr/psr-11/). Examples below will use the Invoices resource, but the process & functionality is pretty much the same regardless of the resource.


### Configuring the environment

Environment is contained on its own class, and it's up to you where you want to pull the constructor arguments (dotenv, Laravel config, anyhting goes). Example below uses Laravel's `config` helper.

Dependencies:
- PSR-17 compatible URI facotry, for example [php-extended/php-http-message-factory-psr17](https://gitlab.com/php-extended/php-http-message-factory-psr17)

```php
use Procountor\Procountor\Environment;
use PhpExtended\HttpMessage\UriFactory;

new Environment(
    config('procountor.client_id'),
    config('procountor.client_secret'),
    config('procountor.api_key'),
    config('procountor.base_uri'),
    config('procountor.redirect_uri'),
    new UriFactory()
);
```



### Creating an API Client

An API Client is an abstraction over stuff that handles the serialization & deserialization, HTTP communication etc. Its an essential dependecy for each resource, so every time you want to do anything with a resource, you must create an instance of an API client fist.

Dependencies:
- PSR-18 HTTP Client library, [Guzlle](https://docs.guzzlephp.org/en/stable/) is a common choice
- PSR-17 compatible HTTP Request factory, for example [php-extended/php-http-message-factory-psr17](https://gitlab.com/php-extended/php-http-message-factory-psr17)
- PSR-17 compatible Stream Factory, for example [php-extended/php-http-message-factory-psr17](https://gitlab.com/php-extended/php-http-message-factory-psr17)
- PSR-3 compatilbe logger, for example [monolog](http://seldaek.github.io/monolog/)
- Environment configured above
- PSR-6 compatible cache item pool, you can use something like [ArrayCachePool](https://github.com/php-cache/array-adapter) if you don't have a cache setup

```php
use Cache\Adapter\PHPArray\ArrayCachePool;
use GuzzleHttp\Client as GuzzleHttpClient;
use PhpExtended\HttpMessage\{RequestFactory, StreamFactory};
use PhpExtended\HttpMessage\UriFactory;
use Psr\Log\NullLogger;

new Client(
    new GuzzleHttpClient(),
    new RequestFactory(),
    new StreamFactory(),
    new NullLogger(),
    $environment, // example above
    new ArrayCachePool()
);
```

### Usign API resources

Procountor's [official API documentation](https://dev.procountor.com/api-reference/) is probably your best friend here.

Dependeicies:
- API client configured above
- If you want to create resources, you must implement your own adapter;
    ```php
    use \Procountor\Interfaces\Write\Invoice as InvoiceInterface;

    class MyInvoiceAdapter implements InvoiceInterface
    {
        private $data;

        public function __construct($yourdata) {
            // you are free to implement this however you see fit
            $this->data = $yourdata;
        }

        // then create the related getters:

        public function getPartnerId() {
            return $this->data->partnerid;
        }
        // ...etc
    }
    ```

```php
use Procountor\Procountor\Resources\Invoices;

$invoicesApi = new Invoices($client);

// Listing resources
$invoices = $invoicesApi->get();

// Fetching a singular resource, takes a resource ID as argument
$invoicesApi->get(1212);

// Creating a resource (see note about adapters above)
$invoicesApi->post(new MyInvoiceAdapter($someData));
```


## Further reading:

- [Using with Laravel](./docs/laravel.md)
- [About testing](./docs/testing.md)
- [About code architechure](./docs/code_architecture.md)
- [Procountor documentation](https://dev.procountor.com/api-reference/)
- [The original project](https://github.com/Fisplay/procountor-php)
