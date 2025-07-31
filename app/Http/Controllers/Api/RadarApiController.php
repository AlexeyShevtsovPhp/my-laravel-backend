<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class RadarApiController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function load(Request $request): JsonResponse
    {
        $apiKey = config('radar.api_key');
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'addresses' => [],
            ]);
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
            return response()->json($data);
        }
        return response()->json([
            'error' => 'Не удалось получить данные от Radar API',
        ], $response->status());
    }
}
