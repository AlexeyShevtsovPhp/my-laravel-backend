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
use Illuminate\Http\Response;
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

    public function create(CreateNewGood $createNewGood): Response
    {
        $path = $this->uploadService->handle($createNewGood);

        $validated = $createNewGood->validated();
        $validated['image'] = $path;

        if ($this->goodRepository->existsByName($validated['name'])) {
            return response()->noContent(422);
        }

        $this->goodRepository->create($validated);

        return response()->noContent(201);
    }

    /**
     * @param ChangeGood $changeGood
     * @param Good $good
     * @return JsonResponse
     */
    public function change(ChangeGood $changeGood, Good $good): JsonResponse
    {
        $validated = $changeGood->validated();
        $path = $this->uploadService->handle($changeGood);

        if ($path) {
            $validated['image'] = $path;
        }

        $good->fill($validated);
        if (!$good->isDirty()) {
            return response()->json('', 204);
        }

        $updatedGood = $this->goodRepository->update($good->id, $validated);
        return response()->json(new GoodChangeResource($updatedGood), 201);
    }
}
