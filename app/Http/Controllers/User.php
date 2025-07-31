<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use App\Models\Comment;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class User extends Controller
{
    public function index(): object
    {
        /** @var ModelsUser $user */
        $user = Auth::user();
        $role = $user->role;

        $path = match ($role) {
            'admin' => "/images/userIcon/admin.png",
            'guest' => "/images/userIcon/guest.png",
            default => "",
        };

        return view('index', [
            'date' => $user->created_at,
            'name' => $user->name,
            'role' => $user->role,
            'path' => $path,
        ]);
    }

    public function show(ModelsUser $user): object
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        $comments = Comment::query()
            ->with('user')
            ->where('user_id', $user->id)
            ->paginate(5);

        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            if (isset($_GET['/monolit/'])) {
                return redirect('/monolit/categories/1?page=1');
            } else {
                return redirect('/categories');
            }
        }

        return view('account', [
            'comments' => $comments,
            'date' => $user->created_at,
            'name' => $user->name,
            'role' => $user->role,
            'content' => $user->content,
            'user' => $user,
            'user_id' => $user->id,
        ]);
    }
}
