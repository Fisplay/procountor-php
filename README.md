# procountor-php

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

//connecting to invoices endpoint of api
$invoicesApi = new Invoices($client);

//Search invoices
$invoicesApi = $invoices->get();


//Get an invoice
$invoicesApi->get(1212);


//posting new invoice

//First implement your own adapter
$newinvoice = new class($yourdata) extends \Procountor\Interfaces\Write\Invoice {
    private $data;

    public function __construct($yourdata) {
        $this->data = $yourdata;
    }

    //Create all getters

    public function getPartnerId() {
        return $this->data->partnerid;
    }

    .....................
}

$invoice = $invoicesApi->post($newInvoice),
