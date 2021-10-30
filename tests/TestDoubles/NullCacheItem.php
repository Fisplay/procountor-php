<?php

namespace Procountor\Tests\TestDoubles;

use Psr\Cache\CacheItemInterface;
use Serializable;


class NullCacheItem implements CacheItemInterface
{

    private string $key;


    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get(): ?Serializable
    {
        return null;
    }

    public function set($value = null, ?int $ttl = null): self
    {
        return $this;
    }

    public function isHit(): bool
    {
        return false;
    }

    public function expiresAt($expiration = null): self
    {
        return $this;
    }

    public function expiresAfter($time = null): self
    {
        return $this;
    }

}
