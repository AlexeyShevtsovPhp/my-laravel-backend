<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\RateProduct;

#[AllowDynamicProperties]
class RatingGoods extends Controller
{
    public function rate(RateProduct $request): JsonResponse
    {
        $data = $request->validated();

        $rating = Rate::where('product_id', $data['productId'])
            ->where('user_id', $data['userId'])
            ->first();

        if ($rating) {
            $rating->rating = $data['rating'];
            $rating->save();
        } else {
            Rate::create([
                'product_id' => $data['productId'],
                'user_id' => $data['userId'],
                'rating' => $data['rating'],
            ]);
        }

        return response()->json(['success' => true]);
    }
}
