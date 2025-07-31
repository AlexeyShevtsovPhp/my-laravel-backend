<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use App\Models\Category as ModelCategory;
use App\Models\User;
use App\Models\Goods;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Category extends Controller
{
    public function index(): object
    {
        $user = Auth::user();
        $button = '';

        switch ($user->role) {
            case 'admin':
                $path = "/images/userIcon/admin.png";
                $button = 'active';
                break;
            case 'guest':
                $path = "/images/userIcon/guest.png";
                $button = 'not-active';
                break;
            default:
                $path = '';
        }
        return view('categories', [
            'button' => $button,
            'user' => $user,
            'path' => $path,
        ]);
    }

    public function show($categoryId): object
    {
        $user = Auth::user();
        $button = '';

        switch ($user->role) {
            case 'admin':
                $button = 'active';
                break;
            case 'guest':
                $button = 'not-active';
                break;
            default:
        }
        $category_id = $categoryId;
        $category = ModelCategory::query()
            ->where('id', $category_id)
            ->first();

        $path = match ($user->role) {
            User::ROLE_ADMIN => "/images/userIcon/admin.png",
            'guest' => "/images/userIcon/guest.png",
            default => '',
        };
        return view('categories', [
            'user' => $user,
            'path' => $path,
            'button' => $button,
            'category_name' => $category->name,
            'category' => $category,
        ]);
    }
}
