<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Controllers\Monolit\Cart;
use App\Http\Requests\BuyMailRequest;
use App\Http\Requests\SendMailRequest;
use App\Models\Good;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

#[AllowDynamicProperties]
class FeedbackApiController extends Controller
{
    public function send(SendMailRequest $request): JsonResponse
    {
        $validated = $request->validated();

        Mail::raw($validated['message'], function ($mail) use ($validated) {
            $mail->from($validated['email'], $validated['name']);
            $mail->to('shautsou.aliaksei@innowise.com')
            ->subject('Обратная связь: ' . $validated['subject'])
                ->replyTo($validated['email'], $validated['name']);
        });
        return response()->json(['message' => 'Сообщение успешно отправлено!']);
    }

    public function get(): JsonResponse
    {

        try {
            $user = Auth::user();

            $cartItems = $user->goods()->withPivot('quantity')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Корзина пуста.'], 400);
            }

            $message = "Здравствуйте, {$user->name}, спасибо за вашу покупку.\n\n";
            $message .= "Список приобретенных товаров:\n";

            $totalSum = 0;

            foreach ($cartItems as $good) {
                $quantity = $good->pivot->quantity;
                $price = $good->price;
                $lineSum = $price * $quantity;

                $message .= "{$good->name} x{$quantity} = {$lineSum}₽\n";
                $totalSum += $lineSum;
            }

            $message .= "\nИтог к оплате: {$totalSum}₽";

            Mail::raw($message, function ($mail) use ($user) {
                $mail->from('laravelShop@gmail.com');
                $mail->to($user->email, $user->name)
                    ->subject('Спасибо за покупку');
            });

            return response()->json([
                'success' => true,
                'message' => 'Сообщение успешно отправлено!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Произошла ошибка при оплате товаров'
            ], 500);
        }
    }
}
