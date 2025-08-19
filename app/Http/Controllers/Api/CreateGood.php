<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\ChangeGood;
use App\Http\Requests\CreateNewGood;
use App\Http\Resources\GoodChangeResource;
use App\Models\Good;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class CreateGood extends Controller
{
    /**
     * @param CreateNewGood $request
     * @return JsonResponse
     */

    public function create(CreateNewGood $request): JsonResponse
    {
        $uploadService = new ImageUploadService();
        $path = $uploadService->handle($request);

        $validated = $request->validated();
        $validated['image'] = $path;

        if (Good::where('name', $validated['name'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Данный товар уже существует',
            ], 422);
        }
        Good::create($validated);

        $response = [
            'success' => true,
            'message' => 'Товар успешно добавлен',
        ];

        return response()->json($response);
    }

    /**
     * @param ChangeGood $request
     * @param Good $good
     * @return JsonResponse
     */

    public function change(ChangeGood $request, Good $good): JsonResponse
    {
        $uploadService = new ImageUploadService();
        $path = $uploadService->handle($request);

        $validated = $request->validated();

        if ($path) {
            $validated['image'] = $path;
        }

        $good->fill($validated);

        if (!$good->isDirty()) {
            return response()->json(['success' => false], 422);
        }

        $good->save();

        return response()->json([
            'success' => true,
            'message' => 'Товар успешно обновлен',
            'good' => new GoodChangeResource($good),
        ]);
    }
}
