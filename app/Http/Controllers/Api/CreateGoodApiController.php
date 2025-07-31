<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\ChangeGoodRequest;
use App\Http\Requests\CreateGoodRequest;
use App\Models\Good;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class CreateGoodApiController extends Controller
{
    public function create(ChangeGoodRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $validated['image'] = $path;
        }

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

    public function change(ChangeGoodRequest $request, Good $good): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $validated['image'] = $path;
        }

        $changes = array_diff_assoc($validated, $good->getAttributes());

        if (empty($changes)) {
            return response()->json([
                'success' => false,
            ], 422);
        }

        $good->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Товар успешно обновлен',
            'good' => $good,
        ]);
    }
}
