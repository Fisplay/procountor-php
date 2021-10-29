<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Client;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Response\AbstractResponse;
use Procountor\Procountor\Exceptions\ClientException;
use Procountor\Procountor\Exceptions\NotImplementedException;

class AbstractResourceRequest
{
    protected string $apiPath;
    protected string $interfaceIn;
    protected string $interfaceOut;
    protected string $collectionType;
    protected Client $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(AbstractResourceInterface $item): AbstractResponse
    {
        if (!(get_class($item) != $this->interfaceIn)) {
            throw new ClientException(sprintf('Invalid item. Expected %s, got %s', $this->interfaceIn, get_class($item)));
        }

        $response = $this->client->post($this->apiPath, $item);
        return $this->createResponse($response);
    }

    public function get(int $id = null): AbstractResponse
    {
        $path = $this->apiPath;
        if ($id) {
            $path .= '/' . $id;
        }
        $response = $this->client->get($path);


        return $this->createResponse($response);
    }

    public function put(int $id, AbstractResourceInterface $item): AbstractResponse
    {
        if (!(get_class($item) != $this->interfaceIn)) {
            throw new ClientException(sprintf('Invalid item. Expected %s, got %s', $this->interfaceIn, get_class($item)));
        }

        $response = $this->client->put($this->apiPath . '/' . $id, $item);
        return $this->createResponse($response);
    }

    public function delete()
    {
        throw new NotImplementedException('Method DELETE not implemented yet.');
    }

    protected function createResponse($response)
    {
        $clsOut = $this->interfaceOut;
        switch (gettype($response)) {
            case 'object':
                return new $clsOut($response);
            case 'array':
                $clsOut .= 'List';
                //abstract response needs stdclass in
                $response = (object)['items' => $response];
                return new $clsOut($response);
            default:
                throw new ClientException('Invalid response or server error!');
        }
    }
}
