<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Артём',
            'role' => 'admin',
            'password' => Hash::make('1111'),
            'created_at' => now(),
        ]);
        User::factory(9)->create([
            'role' => 'guest',
            'created_at' => now(),
        ]);
}}
