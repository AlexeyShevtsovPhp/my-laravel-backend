<?php

namespace App\Http\Controllers\Monolit;

use AllowDynamicProperties;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Good;
use App\Models\User;
use App\Models\Category as ModelCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Categories extends Controller
{
    public function show(Category $category): object
    {
        $user = Auth::user();
        $button = '';

        $path = match ($user->role) {
            User::ROLE_ADMIN => "/images/userIcon/admin.png",
            'guest' => "/images/userIcon/guest.png",
            default => '',
        };
        $allGoods = $user->goods()->get();

        $categories = ModelCategory::query()
            ->select('id', 'name')
            ->get();

        $comments = Comment::query()
            ->where('category_id', $category->id)
            ->with('user')
            ->paginate(4);

        $goods = Good::query()
            ->where('category_id', $category->id)
            ->get();

        switch ($user->role) {
            case 'admin':
                $button = 'active';
                break;
            case 'guest':
                $button = 'not-active';
                break;
            default:
        }
        return view('monolit/categories', [
            'button' => $button,
            'user' => $user,
            'path' => $path,
            'categories' => $categories,
            'comments' => $comments,
            'categorySelected' => $category,
            'goods' => $goods,
            'allGoods' => $allGoods,
        ]);
    }
}
