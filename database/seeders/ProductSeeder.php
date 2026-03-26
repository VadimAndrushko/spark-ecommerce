<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Smartphones
            ['category_slug' => 'smartphones', 'name' => 'iPhone 15 Pro', 'slug' => 'iphone-15-pro', 'description' => 'Новітній флагман від Apple з чипом A17', 'sku' => 'IPHONE-15-PRO', 'price' => 49999, 'cost' => 35000, 'stock' => 15, 'rating' => 4.8, 'reviews' => 245],
            ['category_slug' => 'smartphones', 'name' => 'Samsung Galaxy S24', 'slug' => 'samsung-galaxy-s24', 'description' => 'Потужний смартфон з AI функціями', 'sku' => 'SGS24-001', 'price' => 42999, 'cost' => 30000, 'stock' => 22, 'rating' => 4.7, 'reviews' => 189],
            ['category_slug' => 'smartphones', 'name' => 'Google Pixel 8 Pro', 'slug' => 'google-pixel-8-pro', 'description' => 'Смартфон з кращою камерою та ШІ помічником', 'sku' => 'PIXEL8PRO', 'price' => 39999, 'cost' => 28000, 'stock' => 18, 'rating' => 4.6, 'reviews' => 156],
            ['category_slug' => 'smartphones', 'name' => 'Xiaomi 14 Ultra', 'slug' => 'xiaomi-14-ultra', 'description' => 'Преміум смартфон з чудовою камерою', 'sku' => 'XIAOMI-14U', 'price' => 34999, 'cost' => 24000, 'stock' => 25, 'rating' => 4.5, 'reviews' => 312],
            ['category_slug' => 'smartphones', 'name' => 'OnePlus 12', 'slug' => 'oneplus-12', 'description' => 'Швидкий смартфон з Snapdragon 8 Gen 3', 'sku' => 'ONEPLUS12', 'price' => 31999, 'cost' => 22000, 'stock' => 30, 'rating' => 4.4, 'reviews' => 278],

            // Laptops
            ['category_slug' => 'laptops', 'name' => 'MacBook Air M3', 'slug' => 'macbook-air-m3', 'description' => 'Ультралегкий ноутбук з чипом M3', 'sku' => 'MBAIR-M3', 'price' => 59999, 'cost' => 42000, 'stock' => 8, 'rating' => 4.9, 'reviews' => 324],
            ['category_slug' => 'laptops', 'name' => 'Dell XPS 15', 'slug' => 'dell-xps-15', 'description' => 'Потужний ноутбук для дизайнерів та розробників', 'sku' => 'DELLXPS15', 'price' => 54999, 'cost' => 38000, 'stock' => 12, 'rating' => 4.7, 'reviews' => 198],
            ['category_slug' => 'laptops', 'name' => 'Lenovo ThinkPad X1', 'slug' => 'lenovo-thinkpad-x1', 'description' => 'Професійний ноутбук для бізнесу', 'sku' => 'TPXONE', 'price' => 49999, 'cost' => 35000, 'stock' => 16, 'rating' => 4.6, 'reviews' => 167],
            ['category_slug' => 'laptops', 'name' => 'ASUS VivoBook 16', 'slug' => 'asus-vivobook-16', 'description' => 'Ноутбук з великим экраном для мультимедія', 'sku' => 'ASUSVIVOBOOK', 'price' => 34999, 'cost' => 24000, 'stock' => 20, 'rating' => 4.5, 'reviews' => 245],

            // Headphones
            ['category_slug' => 'headphones', 'name' => 'AirPods Pro Max', 'slug' => 'airpods-pro-max', 'description' => 'Преміум бездротові навушники від Apple', 'sku' => 'APPRODMAX', 'price' => 19999, 'cost' => 14000, 'stock' => 12, 'rating' => 4.8, 'reviews' => 567],
            ['category_slug' => 'headphones', 'name' => 'Sony WH-1000XM5', 'slug' => 'sony-wh-1000xm5', 'description' => 'Навушники з активним шумопотиском', 'sku' => 'SONY1000XM5', 'price' => 17999, 'cost' => 12500, 'stock' => 18, 'rating' => 4.7, 'reviews' => 489],
            ['category_slug' => 'headphones', 'name' => 'Bose QuietComfort EQ', 'slug' => 'bose-quietcomfort-eq', 'description' => 'Комфортні навушники з глибоким басом', 'sku' => 'BOSEQCEQ', 'price' => 16999, 'cost' => 11800, 'stock' => 15, 'rating' => 4.6, 'reviews' => 334],
            ['category_slug' => 'headphones', 'name' => 'Samsung Galaxy Buds Pro', 'slug' => 'samsung-galaxy-buds-pro', 'description' => 'Компактні навушники з гарною якістю звуку', 'sku' => 'SAMSBUDS', 'price' => 9999, 'cost' => 7000, 'stock' => 25, 'rating' => 4.4, 'reviews' => 412],

            // Watches
            ['category_slug' => 'watches', 'name' => 'Apple Watch Series 9', 'slug' => 'apple-watch-series-9', 'description' => 'Розумний годинник з OLED екраном', 'sku' => 'APPWATCH9', 'price' => 14999, 'cost' => 10500, 'stock' => 20, 'rating' => 4.7, 'reviews' => 678],
            ['category_slug' => 'watches', 'name' => 'Samsung Galaxy Watch 6', 'slug' => 'samsung-galaxy-watch-6', 'description' => 'Розумний годинник на Wear OS', 'sku' => 'SAMWATC6', 'price' => 11999, 'cost' => 8500, 'stock' => 18, 'rating' => 4.5, 'reviews' => 456],
            ['category_slug' => 'watches', 'name' => 'Garmin Epix', 'slug' => 'garmin-epix', 'description' => 'Спортивний смарт-годинник з AMOLED', 'sku' => 'GARMEPIX', 'price' => 13999, 'cost' => 9800, 'stock' => 12, 'rating' => 4.6, 'reviews' => 289],

            // Accessories
            ['category_slug' => 'accessories', 'name' => 'Apple MagSafe Charger', 'slug' => 'apple-magsafe-charger', 'description' => 'Магнітна бездротова зарядка для iPhone', 'sku' => 'APMAGSAFE', 'price' => 1999, 'cost' => 1200, 'stock' => 50, 'rating' => 4.6, 'reviews' => 834],
            ['category_slug' => 'accessories', 'name' => 'Tempered Glass Screen Protector', 'slug' => 'tempered-glass-protector', 'description' => 'Захисне скло для смартфона', 'sku' => 'TEMPGLASS', 'price' => 299, 'cost' => 100, 'stock' => 200, 'rating' => 4.4, 'reviews' => 1256],
            ['category_slug' => 'accessories', 'name' => 'USB-C Cable 2m', 'slug' => 'usb-c-cable-2m', 'description' => 'Якісний кабель USB-C 2 метри', 'sku' => 'USBCABLE2M', 'price' => 499, 'cost' => 150, 'stock' => 150, 'rating' => 4.5, 'reviews' => 567],
            ['category_slug' => 'accessories', 'name' => 'Leather Phone Case', 'slug' => 'leather-phone-case', 'description' => 'Шкіряний чохол для телефона', 'sku' => 'LEATHERCASE', 'price' => 1299, 'cost' => 450, 'stock' => 80, 'rating' => 4.7, 'reviews' => 234],

            // Power Banks
            ['category_slug' => 'power-banks', 'name' => 'Anker PowerCore 26800mAh', 'slug' => 'anker-powercore-26800', 'description' => 'Портативна батарея з великою ємністю', 'sku' => 'ANKERPOW', 'price' => 2999, 'cost' => 1800, 'stock' => 45, 'rating' => 4.7, 'reviews' => 892],
            ['category_slug' => 'power-banks', 'name' => 'Xiaomi Mi Power Bank 10000', 'slug' => 'xiaomi-power-bank-10000', 'description' => 'Компактна батарея 10000 мА·год', 'sku' => 'XIAOMIPOW', 'price' => 999, 'cost' => 500, 'stock' => 100, 'rating' => 4.5, 'reviews' => 1245],
        ];

        foreach ($products as $product) {
            $category = Category::where('slug', $product['category_slug'])->first();
            if ($category) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'description' => $product['description'],
                    'sku' => $product['sku'],
                    'price' => $product['price'],
                    'cost' => $product['cost'],
                    'stock_quantity' => $product['stock'],
                    'rating' => $product['rating'],
                    'review_count' => $product['reviews'],
                    'is_active' => true,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
