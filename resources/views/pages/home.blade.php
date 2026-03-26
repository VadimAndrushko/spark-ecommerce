@extends('layouts.app')

@section('title', 'Spark - Лідер е-комерції в Україні')

@section('content')
    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white py-20 rounded-lg mb-12">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <div>
                <h1 class="text-5xl font-bold mb-4">⚡ Spark</h1>
                <p class="text-xl mb-6 max-w-md">Найбільший вибір електроніки та техніки з гарантією якості</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-8 py-3 rounded-lg transition">
                    Переглянути каталог →
                </a>
            </div>
            <div class="text-6xl">📱💻⌚🎧</div>
        </div>
    </section>

    <!-- Quick Features -->
    <section class="mb-12 grid grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">🚚</div>
            <h3 class="font-bold mb-2">Швидка Доставка</h3>
            <p class="text-sm text-gray-600">По Україні за 1-2 робочі дні</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">✅</div>
            <h3 class="font-bold mb-2">Гарантія Якості</h3>
            <p class="text-sm text-gray-600">Перевірено при отриманні</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">↩️</div>
            <h3 class="font-bold mb-2">Легке Повернення</h3>
            <p class="text-sm text-gray-600">14 днів для розмислу</p>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Популярні Категорії</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($categories ?? [] as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center cursor-pointer group">
                    <div class="text-4xl mb-3 group-hover:scale-125 transition">📦</div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-yellow-500">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-500 mt-2">{{ $category->products_count ?? 0 }} товарів</p>
                </a>
            @empty
                <p class="text-gray-500 col-span-full text-center">Категорій не знайдено</p>
            @endforelse
        </div>
    </section>

    <!-- Top Products -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6">⭐ Топ Товари</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($topProducts ?? [] as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p class="text-gray-500 col-span-full text-center">Товари не знайдені</p>
            @endforelse
        </div>
    </section>

    <!-- Special Offers -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6">🔥 Спеціальні Пропозиції</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($specialProducts ?? [] as $product)
                <div class="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                    <div class="h-48 bg-red-900 flex items-center justify-center">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300x300' }}" 
                            alt="{{ $product->name }}" class="h-full w-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold">₴{{ number_format($product->price, 0) }}</span>
                            <span class="bg-yellow-400 text-red-700 font-bold px-2 py-1 rounded">СКИДКА</span>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-red-700 font-bold py-2 rounded transition">
                                Додати у кошик
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">Спеціальні пропозиції недоступні</p>
            @endforelse
        </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-white rounded-lg shadow p-12 mb-12 text-center">
        <h2 class="text-2xl font-bold mb-4">Підпишіться на Новини</h2>
        <p class="text-gray-600 mb-6">Отримуйте першими інформацію про скидки та нові товари</p>
        <form class="flex max-w-md mx-auto gap-2">
            <input type="email" placeholder="Ваш email" class="flex-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded-lg transition">
                Підписатись
            </button>
        </form>
    </section>

    <!-- Brands -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Офіційні Партнери</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach(['Apple', 'Samsung', 'Google', 'Sony', 'LG', 'Xiaomi'] as $brand)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                    <p class="font-bold text-gray-800">{{ $brand }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">🔒</div>
            <h3 class="font-bold mb-2">Надійність</h3>
            <p class="text-sm text-gray-600">5+ років на ринку з мільйонами задоволених покупців</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">💰</div>
            <h3 class="font-bold mb-2">Найбільш Конкурентні Ціни</h3>
            <p class="text-sm text-gray-600">Гарантія найнижчої ціни або поверн разниці</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">👥</div>
            <h3 class="font-bold mb-2">Відмінна Підтримка</h3>
            <p class="text-sm text-gray-600">Цілодобова підтримка в чаті та по телефону</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-4xl mb-3">⚡</div>
            <h3 class="font-bold mb-2">Швидкість</h3>
            <p class="text-sm text-gray-600">Обробка замовлення менше ніж за 1 господину</p>
        </div>
    </section>
@endsection
