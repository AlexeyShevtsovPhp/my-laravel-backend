<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\SendMail;
use App\Models\User;
use App\Services\FeedbackService;
use App\Services\PurchaseMailerService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

#[AllowDynamicProperties]
class FeedbackController extends Controller
{
    public function __construct(
        protected FeedbackService $feedbackService,
        protected PurchaseMailerService $purchaseMailerService,
        protected UserRepository $userRepository
    )
    {
    }

    /**
     * @param SendMail $sendMail
     * @return Response
     */
    public function send(SendMail $sendMail): Response
    {
        /** @var array{message: string, email: string, name: string, subject: string} $validatedData */
        $validatedData = $sendMail->validated();
        $this->feedbackService->sendFeedback($validatedData);
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function buy(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $cartItems = $this->userRepository->getCartItems($user);

        $message = view('purchaseConfirm', ['user' => $user, 'cartItems' => $cartItems])->render();
        $this->purchaseMailerService->sendPurchaseConfirmation($user, $message);

        return response()->noContent();
    }
}
