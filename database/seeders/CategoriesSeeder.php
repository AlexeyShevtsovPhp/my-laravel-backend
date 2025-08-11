<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Спорт'],
            ['name' => 'Готовка'],
            ['name' => 'Охота'],
            ['name' => 'Рыбалка'],
            ['name' => 'Акультизм'],
            ['name' => 'Авто'],
            ['name' => 'Аэробика'],
            ['name' => 'Грубиянство'],
            ['name' => 'Исскуство'],
            ['name' => 'Бизнес'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        foreach ($categories as $category) {
            Category::query()->create($category);
        }
    }
}
