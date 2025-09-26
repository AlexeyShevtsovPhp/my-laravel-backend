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
        $validated = $createNewGood->validated();

        $this->goodRepository->
        create(array_merge($validated, ['image' => $this->uploadService->handle($createNewGood)]));

        return response()->noContent(201);
    }

    /**
     * @param ChangeGood $changeGood
     * @param Good $good
     * @return Response|GoodChangeResource
     */
    public function change(ChangeGood $changeGood, Good $good): Response|GoodChangeResource
    {
        $validated = $changeGood->validated();

        $path = $this->uploadService->handle($changeGood);

        $data = array_merge($validated, $path ? ['image' => $path] : []);

        $good->fill($data);

        if (!$good->isDirty()) {
            return response()->noContent();
        }

        return new GoodChangeResource($this->goodRepository->update($good->id, $data));
    }
}
