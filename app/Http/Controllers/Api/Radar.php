<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\RadarAddressCollectionResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class Radar extends Controller
{
    /**
     * @throws ConnectionException
     */

    /**
     * @throws ConnectionException
     */

    /**
     * @param Request $request
     * @return RadarAddressCollectionResource
     * @throws ConnectionException
     */

    public function load(Request $request): RadarAddressCollectionResource
    {
        $apiKey = config('radar.api_key');
        $query = $request->input('query');

        if (!$query) {
            return new RadarAddressCollectionResource(collect([]));
        }

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get('https://api.radar.io/v1/search/autocomplete', [
            'query' => $query,
            'country' => 'BY',
            'near' => '52.4345,30.9754',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            /** @var array<int, array<string, mixed>> $addressesData */
            $addressesData = $data['addresses'] ?? [];
            $addresses = collect($addressesData);

            return new RadarAddressCollectionResource($addresses);
        }

        return new RadarAddressCollectionResource(collect([]));
    }
}
