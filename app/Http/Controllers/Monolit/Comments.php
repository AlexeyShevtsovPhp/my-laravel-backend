<?php

namespace App\Http\Controllers\Monolit;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Comments extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request, $categoryId = 1): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $message = $request->input('message');

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Необходимо заполнить поле комментария')
                ->withErrors($validator);
        }

        $comment = Comment::query()->create([
            'user_id' => $user->id,
            'content' => $message,
            'category_id' => $categoryId,
        ]);
        $success = (bool)$comment;

        if ($success) {
            return redirect()->back()->with('success', 'Ваш комментарий был успешно добавлен!');
        } else {
            return redirect()->back()->with('error', 'Не удалось добавить комментарий. Попробуйте еще раз.');
        }
    }
}
