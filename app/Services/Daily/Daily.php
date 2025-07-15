<?php

namespace App\Services\Daily;

use Illuminate\Support\Facades\Http;

class Daily
{
    use Endpoints\Logs,
        Endpoints\MeetingAnalytics,
        Endpoints\MeetingTokens,
        Endpoints\Presence,
        Endpoints\Recordings,
        Endpoints\Rooms;

    protected function get(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('GET', $endpoint, $data, $headers);
    }

    protected function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, $data, $headers);
    }

    protected function put(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, $data, $headers);
    }

    protected function patch(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PATCH', $endpoint, $data, $headers);
    }

    protected function delete(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('DELETE', $endpoint, $data, $headers);
    }

    protected function request(string $method, string $endpoint, array $data = [], array $headers = [])
    {
        $endpoint = 'https://api.daily.co/v1/'.$endpoint;

        $headers = array_merge($headers, [
            'Authorization' => 'Bearer '.config('daily.token'),
            'Content-Type' => 'application/json',
        ]);

        $response = Http::withHeaders($headers)->{$method}($endpoint, $data);

        if ($response->status() === 200) {
            return $response->json();
        }

        if ($response->status() === 404) {
            throw new \Exception("Daily API: 404 Not Found - {$endpoint}");
        }

        if ($response->status() === 400) {
            $errorBody = $response->body();
            throw new \Exception("Daily API: Bad Request - {$endpoint}. Response: {$errorBody}");
        }

        if ($response->status() === 401) {
            $errorBody = $response->body();
            throw new \Exception("Daily API: Unauthorized - {$endpoint}. Response: {$errorBody}");
        }

        if ($response->status() === 429) {
            $errorBody = $response->body();
            throw new \Exception("Daily API: Too Many Requests - {$endpoint}. Response: {$errorBody}");
        }

        $errorBody = $response->body();
        throw new \Exception("Daily API: Server Error - {$endpoint}. Status: {$response->status()}. Response: {$errorBody}");
    }
}
