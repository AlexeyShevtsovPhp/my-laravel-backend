<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Requests\SendMailRequest;
use App\Models\User;
use App\Services\FeedbackService;
use App\Services\PurchaseMailerService;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

#[AllowDynamicProperties]
class FeedbackController extends Controller
{
    public function __construct(
        public FeedbackService $feedbackService,
        public PurchaseMailerService $purchaseMailerService,
        public UserRepository $userRepository
    ) {
    }

    /**
     * @param SendMailRequest $sendMailRequest
     * @return Response
     */
    public function send(SendMailRequest $sendMailRequest): Response
    {
        /** @var array{message: string, email: string, name: string, subject: string} $validatedData */
        $validatedData = $sendMailRequest->validated();
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
