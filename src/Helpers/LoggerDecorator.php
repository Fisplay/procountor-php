<?php

namespace Procountor\Helpers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class LoggerDecorator implements LoggerInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logRequest(string $message, RequestInterface $request, ResponseInterface $response): void
    {
        return $this->logger->info(
            $message,
            [
                'url'     => $request->getUri(),
                'method'  => $request->getMethod(),
                'headers' => json_encode($request->getHeaders()),
                'body'    => $request->getBody()->getContents(),
                'status'  => $response->getStatusCode(),
            ]
        );
    }

    public function emergency($message, array $context = []): void
    {
        return $this->logger->emergency($message, $context);
    }

    public function alert($message, array $context = []): void
    {
        return $this->logger->alert($message, $context);
    }

    public function critical($message, array $context = []): void
    {
        return $this->logger->critical($message, $context);
    }

    public function error($message, array $context = []): void
    {
        return $this->logger->error($message, $context);
    }

    public function warning($message, array $context = []): void
    {
        return $this->logger->warning($message, $context);
    }

    public function notice($message, array $context = []): void
    {
        return $this->logger->notice($message, $context);
    }

    public function info($message, array $context = []): void
    {
        return $this->logger->info($message, $context);
    }

    public function debug($message, array $context = []): void
    {
        return $this->logger->debug($message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        return $this->logger->log($message, $context);
    }
}
