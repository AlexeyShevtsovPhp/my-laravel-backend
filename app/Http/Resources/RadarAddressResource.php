<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RadarAddressResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'addressLabel' => $this['addressLabel'] ?? null,
            'formattedAddress' => $this['formattedAddress'] ?? null,
            'latitude' => $this['latitude'] ?? null,
            'longitude' => $this['longitude'] ?? null,
            'country' => $this['country'] ?? null,
            'city' => $this['city'] ?? null,
        ];
    }
}
