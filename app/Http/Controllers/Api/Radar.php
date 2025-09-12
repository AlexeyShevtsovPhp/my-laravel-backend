<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\RadarAddressCollectionResource;
use App\Services\RadarService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Radar extends Controller
{
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
        $radarService = new RadarService();

        $query = $request->input('query');

        if (! $query) {
            return new RadarAddressCollectionResource(collect([]));
        }

        $addresses = $radarService->searchAddresses($query);

        return new RadarAddressCollectionResource(collect($addresses));
    }
}
