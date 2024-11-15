<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\RateLimiter;

class ApiService
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.api_url');
    }


    public function fetchData(string $endpoint, array $params = [])
    {
        try {
            // Fetching the data from the API
            $rateLimitKey = 'api.' . md5($endpoint . json_encode($params));

            return RateLimiter::attempt(
                $rateLimitKey,
                $this->getMaxAttempts(), // Max attempts allowed
                function () use ($endpoint, $params) {
                    return $this->makeRequest($endpoint, $params);
                },
                $this->decaySeconds()
            );

        }  catch (\Exception $e) {
            Log::error('Unexpected API Error', [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function makeRequest(string $endpoint, array $params = [])
    {
        $url = "{$this->baseUrl}/{$endpoint}";

        try {
            $response = Http::get($url, $params);

            if ($response->failed()) {
                Log::error("Failed to fetch data from {$url}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception("Failed to fetch data from {$url}");
            }

            return $response->json();
        } catch (ConnectionException $e) {
            // Connection errors
            Log::error('API Connection Error', [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Failed to connect to the API. Please try again later.', 500);

        } catch (RequestException $e) {
            // Client or server errors
            Log::error('API Request Error', [
                'url' => $url,
                'params' => $params,
                'status' => $response->status() ?? 'N/A',
                'error' => $e->getMessage()
            ]);
            throw new \Exception('API returned an error. Please try again later.', 500);

        }catch (\Exception $e) {
            Log::error('Error during API request', [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function getMaxAttempts(): int
    {
        // Max 3 requests per second and 60 requests per minute
        return 3;
    }

    private function decaySeconds(): int
    {
        return 1;
    }
}
