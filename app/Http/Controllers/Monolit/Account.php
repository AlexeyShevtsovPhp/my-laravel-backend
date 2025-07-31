<?php

namespace App\Http\Controllers\Monolit;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Account extends Controller
{
    public function show(ModelsUser $user): object
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        $comments = Comment::query()
            ->with('user')
            ->where('user_id', $user->id)
            ->paginate(5);

        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return redirect('/categories');
        }

        return view('/monolit/account', [
            'comments' => $comments,
            'date' => $user->created_at,
            'name' => $user->name,
            'role' => $user->role,
            'content' => $user->content,
            'user' => $user,
        ]);
    }
}
