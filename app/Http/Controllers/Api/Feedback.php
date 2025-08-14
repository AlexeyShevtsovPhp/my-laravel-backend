<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\SendMail;
use App\Models\Good;
use App\Models\User;
use App\Services\BuildPurchaseMessage;
use App\Services\FeedbackService;
use App\Services\PurchaseMailerService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Feedback extends Controller
{
    /**
     * @param SendMail $request
     * @return JsonResponse
     */

    public function send(SendMail $request): JsonResponse
    {
        /** @var array{message: string, email: string, name: string, subject: string} $validated */
        $validated = $request->validated();

        $service = new FeedbackService();
        $service->sendFeedback($validated);

        return response()->json(['message' => 'Сообщение успешно отправлено!']);
    }

    /**
     * @return JsonResponse
     */

    public function get(): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            /** @var Collection<int, Good> $cartItems */
            $cartItems = $user->goods()->withPivot('quantity')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Корзина пуста.'], 400);
            }

            $service = new BuildPurchaseMessage();
            $message = $service->buildPurchaseMessage($user, $cartItems);

            $purchaseMailer = new PurchaseMailerService();
            $purchaseMailer->sendPurchaseConfirmation($user, $message);

            return response()->json(['success' => true, 'message' => 'Сообщение успешно отправлено!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Произошла ошибка при оплате товаров'], 500);
        }
    }
}
