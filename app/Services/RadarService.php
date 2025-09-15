<?php

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
     * @throws ConnectionException
     * @return array<int, array<string, mixed>>
     */
    public function searchAddresses(string $query): array
    {
        $url = config('radar.autocomplete_url');
        $response = Http::withHeaders($this->getHeaders())
            ->get($url, [
                'query' => $query,
                'country' => 'BY',
                'near' => '52.4345,30.9754',
            ]);

        if (! $response->successful()) {
            return [];
        }

        $data = $response->json();

        return $data['addresses'];
    }
}
