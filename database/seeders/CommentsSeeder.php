<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
