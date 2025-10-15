<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\ChangeGoodRequest;
use App\Http\Requests\CreateNewGoodRequest;
use App\Models\Good;
use App\Services\ImageUploadService;
use App\Repositories\Good\GoodRepository;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class CreateGoodController extends Controller
{
    /**
     * @param GoodRepository $goodRepository
     * @param ImageUploadService $uploadService
     */
    public function __construct(protected GoodRepository $goodRepository, protected ImageUploadService $uploadService)
    {
    }

    public function create(CreateNewGoodRequest $createNewGood): Response
    {
        $validated = $createNewGood->validated();

        $this->goodRepository->
        create(array_merge($validated, ['image' => $this->uploadService->handle($createNewGood)]));

        return response()->noContent();
    }

    /**
     * @param ChangeGoodRequest $changeGood
     * @param Good $good
     * @return Response
     */
    public function change(ChangeGoodRequest $changeGood, Good $good): Response
    {
        $validated = $changeGood->validated();
        $path = $this->uploadService->handle($changeGood);
        $data = array_merge($validated, $path ? ['image' => $path] : []);
        $good->fill($data);

        if (!$good->isDirty()) {
            return response()->noContent(500);
        }

        $this->goodRepository->update($good->id, $data);

        return response()->noContent();
    }
}
