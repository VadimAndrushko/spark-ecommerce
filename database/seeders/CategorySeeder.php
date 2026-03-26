<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Смартфони', 'slug' => 'smartphones', 'description' => 'Мобільні телефони від провідних виробників', 'image' => null],
            ['name' => 'Ноутбуки', 'slug' => 'laptops', 'description' => 'Портативні комп\'ютери для роботи та розваг', 'image' => null],
            ['name' => 'Планшети', 'slug' => 'tablets', 'description' => 'Портативні планшетні комп\'ютери', 'image' => null],
            ['name' => 'Навушники', 'slug' => 'headphones', 'description' => 'Бездротові та дротові навушники', 'image' => null],
            ['name' => 'Годинники', 'slug' => 'watches', 'description' => 'Розумні та звичайні годинники', 'image' => null],
            ['name' => 'Камери', 'slug' => 'cameras', 'description' => 'Цифрові камери та екшн-камери', 'image' => null],
            ['name' => 'Аксесуари', 'slug' => 'accessories', 'description' => 'Чохли, захисні скла, кабелі, адаптери', 'image' => null],
            ['name' => 'Портативні батареї', 'slug' => 'power-banks', 'description' => 'Батарейні блоки для зарядки пристроїв', 'image' => null],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
