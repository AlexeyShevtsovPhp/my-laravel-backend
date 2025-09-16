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
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

#[AllowDynamicProperties]
class Feedback extends Controller
{
    public function __construct(
        protected FeedbackService $feedbackService,
        protected BuildPurchaseMessage $buildPurchaseMessage,
        protected PurchaseMailerService $purchaseMailerService,
        protected UserRepository $userRepository
    ) {
    }

    /**
     * @param SendMail $sendMail
     * @return Response
     */
    public function send(SendMail $sendMail): Response
    {
        /** @var array{message: string, email: string, name: string, subject: string} $validated */

        $validated = $sendMail->validated();
        $this->feedbackService->sendFeedback($validated);
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function get(): Response
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            $cartItems = $this->userRepository->getCartItems($user);

            if ($cartItems->isEmpty()) {
                return response()->noContent(400);
            }

            $message = $this->buildPurchaseMessage->buildPurchaseMessage($user, $cartItems);
            $this->purchaseMailerService->sendPurchaseConfirmation($user, $message);

            return response()->noContent(200);
        } catch (Exception $e) {
            return response()->noContent(500);
        }
    }
}
