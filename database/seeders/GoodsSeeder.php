<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Good;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsSeeder extends Seeder
{

    public function run(): void
    {
        $goods = [
            ['name' => 'Обруч', 'price' => 50.0, 'category_id' => 1],
            ['name' => 'Скакалка', 'price' => 70.0, 'category_id' => 1],
            ['name' => 'Батут', 'price' => 250.0, 'category_id' => 1],
            ['name' => 'Канат', 'price' => 270.0, 'category_id' => 1],
            ['name' => 'Штанга', 'price' => 45.0, 'category_id' => 1],
            ['name' => 'Колбаса', 'price' => 20.0, 'category_id' => 2],
            ['name' => 'Сыр', 'price' => 35.0, 'category_id' => 2],
            ['name' => 'Масло', 'price' => 70.0, 'category_id' => 2],
            ['name' => 'Груша', 'price' => 200.0, 'category_id' => 2],
            ['name' => 'Вино', 'price' => 220.0, 'category_id' => 2],
            ['name' => 'Винтовка', 'price' => 2820.0, 'category_id' => 3],
            ['name' => 'Патроны', 'price' => 50.0, 'category_id' => 3],
            ['name' => 'Марля', 'price' => 450.0, 'category_id' => 3],
            ['name' => 'Глушитель', 'price' => 5000.0, 'category_id' => 3],
            ['name' => 'Прицел', 'price' => 4550.0, 'category_id' => 3],
            ['name' => 'Приманка', 'price' => 1000.0, 'category_id' => 4],
            ['name' => 'Удочка', 'price' => 2350.0, 'category_id' => 4],
            ['name' => 'Весло', 'price' => 500.0, 'category_id' => 4],
            ['name' => 'Надувная лодка', 'price' => 750.0, 'category_id' => 4],
            ['name' => 'Рыболовные сети', 'price' => 200.0, 'category_id' => 4],
            ['name' => 'Кинжал', 'price' => 1350.0, 'category_id' => 5],
            ['name' => 'Черный ягнёнок', 'price' => 800.0, 'category_id' => 5],
            ['name' => 'Черный капюшон', 'price' => 300.0, 'category_id' => 5],
            ['name' => 'Флакон', 'price' => 1200.0, 'category_id' => 5],
            ['name' => 'Мантия', 'price' => 666.0, 'category_id' => 5],
            ['name' => 'Лимузин', 'price' => 80000000.0, 'category_id' => 6],
            ['name' => 'Шеврале', 'price' => 200000.0, 'category_id' => 6],
            ['name' => 'Лада', 'price' => 800.0, 'category_id' => 6],
            ['name' => 'Порш', 'price' => 800000.0, 'category_id' => 6],
            ['name' => 'ЗИЛ-31', 'price' => 87000000000.0, 'category_id' => 6],
            ['name' => 'Спортивный костюм', 'price' => 870.0, 'category_id' => 7],
            ['name' => 'Коврик', 'price' => 405.0, 'category_id' => 7],
            ['name' => 'Магнитофон', 'price' => 3070.0, 'category_id' => 7],
            ['name' => 'Повязка на голову', 'price' => 80.0, 'category_id' => 7],
            ['name' => 'Кроссовки', 'price' => 2400.0, 'category_id' => 7],
            ['name' => 'Английский словарь', 'price' => 270.0, 'category_id' => 8],
            ['name' => 'Золотая цепь', 'price' => 6000.0, 'category_id' => 8],
            ['name' => 'Блатной телефон', 'price' => 1337.0, 'category_id' => 8],
            ['name' => 'Место на рынке', 'price' => 2000.0, 'category_id' => 8],
            ['name' => 'Авторитет', 'price' => 8888.0, 'category_id' => 8],
            ['name' => 'Кисть', 'price' => 100.0, 'category_id' => 9],
            ['name' => 'Краски', 'price' => 1700.0, 'category_id' => 9],
            ['name' => 'Палитра', 'price' => 400.0, 'category_id' => 9],
            ['name' => 'Берет', 'price' => 250.0, 'category_id' => 9],
            ['name' => 'Белый холст', 'price' => 3333.0, 'category_id' => 9],
            ['name' => 'Деньги', 'price' => 1000.0, 'category_id' => 10],
            ['name' => 'Автомойка', 'price' => 988888.0, 'category_id' => 10],
            ['name' => 'Гараж', 'price' => 8000000000.0, 'category_id' => 10],
            ['name' => 'Ресторан', 'price' => 350000.0, 'category_id' => 10],
            ['name' => 'Ларёк', 'price' => 100.0, 'category_id' => 10],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('goods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        foreach ($goods as $good) {
            Good::query()->create($good);
        }
    }
}
