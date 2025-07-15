<?php

namespace App\Exceptions;

use Exception;

class DailyApiException extends Exception
{
    protected int $statusCode;

    protected array $responseData;

    public function __construct(string $message, int $statusCode = 500, array $responseData = [])
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * Create exception from HTTP response
     */
    public static function fromResponse(\Illuminate\Http\Client\Response $response): self
    {
        $statusCode = $response->status();
        $responseData = $response->json() ?? [];

        $message = match ($statusCode) {
            400 => 'Daily API: Bad Request - '.($responseData['error'] ?? 'Invalid request'),
            401 => 'Daily API: Unauthorized - Check your API key',
            403 => 'Daily API: Forbidden - Insufficient permissions',
            404 => 'Daily API: Not Found - Resource does not exist',
            429 => 'Daily API: Too Many Requests - Rate limit exceeded',
            default => 'Daily API: Server Error - '.($responseData['error'] ?? 'Unknown error'),
        };

        return new self($message, $statusCode, $responseData);
    }
}

class DailyBadRequestException extends DailyApiException {}
class DailyUnauthorizedException extends DailyApiException {}
class DailyForbiddenException extends DailyApiException {}
class DailyNotFoundException extends DailyApiException {}
class DailyTooManyRequestsException extends DailyApiException {}
class DailyServerErrorException extends DailyApiException {}
