<?php

namespace Procountor\Procountor\Resources;

use InvalidArgumentException;
use Procountor\Procountor\Client;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Response\AbstractResponse;
use Procountor\Procountor\Exceptions\ClientException;
use Procountor\Procountor\Exceptions\NotImplementedException;
use ReflectionException;
use RuntimeException;
use Psr\Http\Client\ClientExceptionInterface;
use Procountor\Procountor\Exceptions\ValidationException;
use stdClass;

class AbstractResourceRequest
{
    protected static string $apiPath;
    protected static string $interfaceIn;
    protected static string $interfaceOut;
    protected static string $collectionType;
    protected Client $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create new resource.
     *
     * @param AbstractResourceInterface $item
     * @return AbstractResponse
     * @throws ClientException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     */
    public function post(AbstractResourceInterface $item): AbstractResponse
    {
        if (!(get_class($item) != static::$interfaceIn)) {
            throw new ClientException(sprintf('Invalid item. Expected %s, got %s', static::$interfaceIn, get_class($item)));
        }

        $response = $this->client->post(static::$apiPath, $item);
        return $this->createResponse($response);
    }

    /**
     * Retrieve resource(s)
     *
     * @param int|null $id (optional) Pass in to retreive singular resource
     * @return AbstractResponse
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     * @throws ClientException
     */
    public function get(int $id = null): AbstractResponse
    {
        $path = static::$apiPath;
        if ($id) {
            $path .= '/' . $id;
        }
        $response = $this->client->get($path);


        return $this->createResponse($response);
    }

    /**
     * Update resource
     * @param int $id Resource ID to be updated
     * @param AbstractResourceInterface $item Updated resource
     * @return AbstractResponse
     * @throws ClientException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     */
    public function put(int $id, AbstractResourceInterface $item): AbstractResponse
    {
        if (!(get_class($item) != static::$interfaceIn)) {
            throw new ClientException(sprintf('Invalid item. Expected %s, got %s', static::$interfaceIn, get_class($item)));
        }

        $response = $this->client->put(static::$apiPath . '/' . $id, $item);
        return $this->createResponse($response);
    }

    /**
     * Delete resource. Not implemented yet.
     *
     * @return never
     * @throws NotImplementedException
     */
    public function delete()
    {
        throw new NotImplementedException('Method DELETE not implemented yet.');
    }

    protected function createResponse($response)
    {
        $clsOut = static::$interfaceOut;
        switch (gettype($response)) {
            case 'object':
                return new $clsOut($response);
            case 'array':
                if (isset(static::$collectionType)) {
                    return new static::$collectionType(...array_map(
                        fn (stdClass $item) => new $clsOut($item),
                        $response
                    ));
                }
                $clsOut .= 'List';
                //abstract response needs stdclass in
                $response = (object)['items' => $response];
                return new $clsOut($response);
            default:
                throw new ClientException('Invalid response or server error!');
        }
    }
}
