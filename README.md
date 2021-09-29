# procountor-php

## Laravel installation
- require with composer
- publish configuration with: `php artisan vendor:publish --provider="Procountor\Laravel\ProcountorServiceProvider" --tag="config"`


---
# !! WARNING !!

This README is not up to date. This repository is a fork of https://github.com/Fisplay/procountor-php and not compatible with the original one.

## My goals;
- [ ] remove hard dependecies (Guzzle etc, use DI instead)
- [x] PSR compatible;
    - [x] PSR-3 logger
    - [x] PSR-6 cache interfaces
    - [x] PSR-7 HTTP Message interfaces
    - [x] PSR-17 HTTP Factories
    - [x] PSR-18 HTTP Clients
- [ ] Laravel compatible (can be installed as a Laravel package)
    - [x] ServiceProvider to register client
    - [ ] ServiceProvider to register resources (parital)
    - [x] Config
    - [ ] Facades for resources (partial)
    - [ ] Helper for authorization flow (partial)
- [ ] Modernize test suite (use [Pest](https://pestphp.com/))
- [ ] PHP8 compatibility
- [ ] Document properly using phpdoc (partial)

## Tested working API's
- Invoices
    - Create invoice
    - List invoices

## TODO
- Fix tests
- Write quickstart
- Compare properties for the latest version of the Procountor API
- Export documentation to static site
- Write facades
- Finalize authorization flow (view?)


---
## ORIGINAL ⬇
---
## DOCS ⬇
---
## BELOW ⬇
---

- [Introduction](#introduction)
- [Start](#start)
- [API connection](#apiconnection)
- [Search invoices](#search)
- [Get an invoice](#getinvoice)
- [Posting a new invoice](#postinvoice)

<a name="introduction"></a>
## Introduction
This opensource project is about procountor API

<a name="introduction"></a>
## Start

    use Procountor\Interfaces\LoggerInterface;

    $yourLogger = new class() implements LoggerInterface {....}
    $client = new Client($yourLogger);

    $client->authenticateByApiKey(
        $clientId,
        $clientSecret,
        $redirectUri,
        $apiKey,
        $company
    );

<a name="apiconnection"></a>
## API connection

This is how to connect to invoices's API endpoint:

    $invoicesApi = new Invoices($client);

<a name="search"></a>
## Search invoices

    $invoices = $invoicesApi->get();

<a name="getinvoice"></a>
## Get an invoice

To get an invoice with ID = 1212:

    $invoicesApi->get(1212);

<a name="postinvoice"></a>
# Posting a new invoice

To post a new invoice, you need first to implement your own adapter:

    $newInvoice = new class($yourdata) implements \Procountor\Interfaces\Write\Invoice {
        private $data;

        public function __construct($yourdata) {
            $this->data = $yourdata;
        }

        // then create the related getters:

        public function getPartnerId() {
            return $this->data->partnerid;
        }
        // ...etc
    }

Finally you can properly post the invoice:

    $invoice = $invoicesApi->post($newInvoice)

# Developing

Documents about developing this project can be found under `/doc` directory
