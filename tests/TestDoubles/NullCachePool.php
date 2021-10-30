<?php

namespace Procountor\Tests\TestDoubles;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Traversable;

class NullCachePool implements CacheItemPoolInterface
{

    public function hasItem($key): bool
    {
        return false;
    }

    public function getItem($key): CacheItemInterface
    {
        return new NullCacheItem($key);
    }

    public function getItems(array $keys = []): array|Traversable
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->getItem($key);
        }
        return $result;
    }

    public function clear(): bool
    {
        return true;
    }

    public function deleteItem($key): bool
    {
        return true;
    }

    public function deleteItems(array $keys): bool
    {
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        return true;
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        return true;
    }

    public function commit(): bool
    {
        return true;
    }

}
