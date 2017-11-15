<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\AbstractResourceInterface;

class AbstractResourceRequest {
    protected $apiPath;
    protected $interfaceIn;
    protected $interfaceOut;

    protected $client;


    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function post(AbstractResourceInterface $item)
    {
        if (!(get_class($item)!=$this->interfaceIn)) {
            throw new ClientException(sprintf('Invalid item. Expected %s, got %s', $this->interfaceIn, get_class($item)));
        }

        $response = $this->client->post($this->apiPath, $item);
        return $this->createResponse($response);
    }

    public function get(int $id) {

    }


    public function put() {

    }

    public function delete() {

    }

    private function createResponse($response) {
        $clsOut = $this->interfaceOut;
        return new $clsOut($response);
    }

}
