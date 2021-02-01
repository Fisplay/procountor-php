# procountor-php

- [Introduction](#introduction)
- [Start](#start)
- [API connection](#apiconnection)
- [Search invoices](#search)
- [Get an invoice](#getinvoice)
- [Posting a new invoice](#postinvoice)

<a name="introduction"></a>
## Introduction
This opensource project is about ...

<a name="introduction"></a>
## Start

    use Procountor\Interfaces\LoggerInterface;

    $yourLogger = new class() implements LoggerInterface {....}
    $client = new Client($yourLogger);

    $client->login(
        $clientId,
        $clientSecret,
        $redirectUri,
        $username,
        $password,
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

    $newInvoice = new class($yourdata) extends \Procountor\Interfaces\Write\Invoice {
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
