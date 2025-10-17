<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::query()->whereIn('role', ['admin', 'guest'])->get();

        foreach ($users as $user) {
            Comment::factory()->count(10)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
