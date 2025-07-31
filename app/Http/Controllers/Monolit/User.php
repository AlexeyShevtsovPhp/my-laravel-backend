<?php

namespace App\Http\Controllers\Monolit;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class User extends Controller
{
    public function index(): object
    {
        /** @var ModelsUser $user */
        $user = Auth::user();
        $role = $user->role;
        $users = ModelsUser::query()
            ->select('id', 'name')
            ->paginate(8);

        switch ($role) {
            case 'admin':
                $path = "/images/userIcon/admin.png";
                break;
            case 'guest':
                $path = "/images/userIcon/guest.png";
                break;
            default:
                $path = "";
        }

        return view('/monolit/index', [
            'date' => $user->created_at,
            'name' => $user->name,
            'role' => $user->role,
            'path' => $path,
            'users' => $users,
        ]);
    }

    public function show(ModelsUser $user): object
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        $goods = $user->goods()->paginate(5);

        $allGoods = $user->goods()->get();
        $allComments = $user->comments()->get();

        $comments = Comment::query()
            ->with('user')
            ->where('user_id', $user->id)
            ->paginate(5);
        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return redirect('/categories');
        }
        if ($_GET['type'] === 'comments') {
            $tableName = "Комментарии";
            return view('/monolit/accountComments', [
                'comments' => $comments,
                'date' => $user->created_at,
                'name' => $user->name,
                'role' => $user->role,
                'content' => $user->content,
                'user' => $user,
                'tableName' => $tableName,
                'allGoods' => $allGoods,
            ]);
        } else {
            $tableName = "Заказ";
            return view('/monolit/accountOrder', [
                'date' => $user->created_at,
                'name' => $user->name,
                'role' => $user->role,
                'goods' => $goods,
                'user' => $user,
                'tableName' => $tableName,
                'allComments' => $allComments,
            ]);
        }
    }
}
