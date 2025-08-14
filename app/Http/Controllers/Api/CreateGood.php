<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\ChangeGood;
use App\Http\Requests\CreateNewGood;
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
        $good = Good::create($validated);

        $response = [
            'success' => true,
            'message' => 'Товар успешно добавлен',
            'good' => $good,
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
        $validated['image'] = $path;

        $changes = array_diff_assoc($validated, $good->getAttributes());

        if (empty($changes)) {
            return response()->json(['success' => false], 422);
        }

        $good->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Товар успешно обновлен',
            'good' => $good,
        ]);
    }
}
