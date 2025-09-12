<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\SendMail;
use App\Models\User;
use App\Services\BuildPurchaseMessage;
use App\Services\FeedbackService;
use App\Services\PurchaseMailerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

#[AllowDynamicProperties]
class Feedback extends Controller
{
    protected FeedbackService $feedbackService;
    protected BuildPurchaseMessage $buildPurchaseMessage;
    protected PurchaseMailerService $purchaseMailerService;
    protected UserRepository $userRepository;

    public function __construct(
        FeedbackService $feedbackService,
        BuildPurchaseMessage $buildPurchaseMessage,
        PurchaseMailerService $purchaseMailerService,
        UserRepository $userRepository
    ) {
        $this->feedbackService = $feedbackService;
        $this->buildPurchaseMessage = $buildPurchaseMessage;
        $this->purchaseMailerService = $purchaseMailerService;
        $this->userRepository = $userRepository;
    }
    /**
     * @param SendMail $request
     * @return JsonResponse
     */
    public function send(SendMail $request): JsonResponse
    {
        /** @var array{message: string, email: string, name: string, subject: string} $validated */

        $validated = $request->validated();
        $this->feedbackService->sendFeedback($validated);
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

            $cartItems = $this->userRepository->getCartItems($user);

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Корзина пуста.'], 400);
            }

            $message = $this->buildPurchaseMessage->buildPurchaseMessage($user, $cartItems);
            $this->purchaseMailerService->sendPurchaseConfirmation($user, $message);

            return response()->json(['success' => true, 'message' => 'Сообщение успешно отправлено!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Произошла ошибка при отправке сообщения'], 500);
        }
    }
}
