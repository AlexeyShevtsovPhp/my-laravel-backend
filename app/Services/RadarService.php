<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class RadarService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('radar.api_key');
    }

    /**
     * @return array<string, string>
     */
    protected function getHeaders(): array
    {
        return [
            'Authorization' => $this->apiKey,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     * @throws ConnectionException
     */
    public function searchAddresses(string $query): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get(config('radar.autocomplete_url'), [
                'query' => $query,
                'country' => config('radar.country'),
                'near' => config('radar.near'),
            ]);

        if (!$response->successful()) {
            return [];
        }

        $data = $response->json();

        return $data['addresses'];
    }
}
