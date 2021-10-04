<?php

namespace Procountor\Procountor\Exceptions;

use Psr\Http\Message\ResponseInterface;
use stdClass;
use Throwable;

/**
 * class ValidationException
 *
 * Throwed if Procountor responded with HTTP 400 Bad Request.
 * Contains details of failed fields.
 *
 * @method int getCode() Returns the original HTTP Status Code
 *
 * @package Procountor\Procountor\Exceptions
 */
class ValidationException extends HttpException
{

    protected string $message = 'Request validation failed.';
    protected array $errors;


    public function __construct(ResponseInterface $response, Throwable $previous = null)
    {
        parent::__construct($response, $previous);
        $responseBody = $this->responseBody();
        switch (gettype($responseBody)) {
            case 'object':
                $this->errors = $responseBody->errors ?? [];
            case 'string':
                $this->errors = ['unknown' => $responseBody];
            default:
                $this->errors = [];
        }
    }

    /**
     * Get all validation errors.
     * Returns associateive array of arrays, where;
     * - key is the field name (dot notation)
     * - value is array of error codes
     *
     * @see https://dev.procountor.com/api-reference/validation-error-codes/
     *
     * @return array<string, string[]>
     */
    public function getErrors(): array
    {
        return array_reduce(
            $this->errors,
            function (array $output, stdClass $input) {
                if (isset($output[$input->field])) {
                    $output[$input->field][] = $input->message;
                } else {
                    $output[$input->field] = [$input->message];
                }
                return $output;
            },
            []
        );
    }
}
