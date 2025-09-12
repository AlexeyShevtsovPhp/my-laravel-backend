<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\ChangeGood;
use App\Http\Requests\CreateNewGood;
use App\Http\Resources\GoodChangeResource;
use App\Models\Good;
use App\Services\ImageUploadService;
use App\Repositories\Good\GoodRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class CreateGood extends Controller
{
    /**
     * @param GoodRepository $goodRepository
     * @param ImageUploadService $uploadService
     */
    public function __construct(protected GoodRepository $goodRepository, protected ImageUploadService $uploadService)
    {
    }

    public function create(CreateNewGood $request): JsonResponse
    {
        $path = $this->uploadService->handle($request);

        $validated = $request->validated();
        $validated['image'] = $path;

        if ($this->goodRepository->existsByName($validated['name'])) { // <-- Стало
            return response()->json([
                'success' => false,
                'message' => 'Данный товар уже существует',
            ], 422);
        }

        $this->goodRepository->create($validated);

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
        $path = $this->uploadService->handle($request);

        $validated = $request->validated();
        if ($path) {
            $validated['image'] = $path;
        }

        $good->fill($validated);
        if (!$good->isDirty()) {
            return response()->json(['success' => false], 422);
        }

        $updatedGood = $this->goodRepository->update($good->id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Товар успешно обновлен',
            'good' => new GoodChangeResource($updatedGood),
        ]);
    }
}
