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
use Procountor\Procountor\Interfaces\ListResult;
use TypeError;

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
     * Search resources
     *
     * @param null|array $searchParams
     * @return object|ListResult
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     * @throws TypeError
     */
    public function search(?array $searchParams = null): ListResult
    {
        $path = static::$apiPath;
        $response = $this->client->get($path, $searchParams);

        return $this->createResponse($response);
    }

    /**
     * Retrieve resource(s)
     *
     * @param int|null $id (optional) Pass in to retreive singular resource
     * @return AbstractResponse|ListResult
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     * @throws ClientException
     */
    public function get(int $id = null)
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

    /**
     * Handle the response.
     *
     * @param mixed $response
     * @return object|ListResult
     * @throws TypeError
     */
    protected function createResponse($response)
    {
        if (gettype($response) !== 'object') {
            throw new TypeError('Resource requests should always receive an object response.');
        }

        // List results
        if (isset($response->results)) {
            return isset(static::$collectionType)
                ? new static::$collectionType($response)
                : $response;
        }

        // Singular items
        return new static::$interfaceOut($response);
    }
}
