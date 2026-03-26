@extends('layouts.app')

@section('title', $product->name . ' | Spark')

@section('content')
    <nav class="text-sm text-gray-600 mb-6">
        <a href="{{ route('home') }}" class="hover:text-yellow-500">Головна</a> / 
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-yellow-500">
            {{ $product->category->name }}
        </a> / 
        <span>{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Product Image & Gallery -->
        <div class="lg:col-span-1">
            <div class="bg-gray-100 rounded-lg p-4 h-96 flex items-center justify-center relative group mb-4">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400?text=' . urlencode($product->name) }}" 
                    alt="{{ $product->name }}" class="h-full w-full object-cover rounded-lg group-hover:scale-110 transition">
                
                @if ($product->stock_quantity > 5)
                    <span class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-lg text-sm font-bold">В наявності</span>
                @elseif ($product->stock_quantity > 0)
                    <span class="absolute top-4 right-4 bg-yellow-500 text-black px-3 py-1 rounded-lg text-sm font-bold">{{ $product->stock_quantity }} шт</span>
                @else
                    <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-bold">Немає</span>
                @endif

                @if ($product->cost && $product->price > $product->cost)
                    <span class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-bold">
                        -{{ round(((($product->price - $product->cost) / $product->price) * 100)) }}%
                    </span>
                @endif
            </div>

            <!-- Wishlist Button -->
            <button class="w-full bg-red-100 hover:bg-red-200 text-red-600 font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                ❤️ Додати до обраного
            </button>
        </div>

        <!-- Product Info -->
        <div class="lg:col-span-2">
            <!-- Category & SKU -->
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-sm text-yellow-500 hover:underline">
                {{ $product->category->name }}
            </a>
            <span class="text-xs text-gray-500 ml-3">SKU: {{ $product->sku }}</span>

            <!-- Title -->
            <h1 class="text-4xl font-bold text-gray-900 my-4">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center">
                    <span class="text-2xl">
                        @for ($i = 0; $i < floor($product->rating); $i++)
                            ⭐
                        @endfor
                    </span>
                    <span class="ml-2 text-lg font-bold">{{ $product->rating }}</span>
                </div>
                <span class="text-gray-600">({{ $product->review_count }} відгуків)</span>
                <a href="#reviews" class="text-yellow-500 hover:underline">Прочитати відгуки</a>
            </div>

            <!-- Price Section -->
            <div class="bg-gray-100 p-6 rounded-lg mb-6">
                <div class="flex items-baseline gap-4">
                    <span class="text-5xl font-bold text-red-600">₴{{ number_format($product->price, 0, ',', ' ') }}</span>
                    @if ($product->cost && $product->price > $product->cost)
                        <span class="text-2xl text-gray-400 line-through">₴{{ number_format($product->cost * 1.5, 0, ',', ' ') }}</span>
                        <span class="text-xl font-semibold text-green-600">Зекономьте ₴{{ number_format($product->price - $product->cost, 0, ',', ' ') }}</span>
                    @endif
                </div>
            </div>

            <!-- Add to Cart -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="flex items-center gap-4 mb-4">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                        class="w-24 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-4 rounded-lg transition text-lg" 
                        {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                        @if ($product->stock_quantity > 0)
                            🛒 Додати в кошик
                        @else
                            Недоступно
                        @endif
                    </button>
                </div>
            </form>

            <!-- Trust Badges -->
            <div class="grid grid-cols-3 gap-4 mb-8 border-t border-b py-6">
                <div class="text-center">
                    <div class="text-3xl mb-2">🚚</div>
                    <p class="text-sm font-semibold">Доставка</p>
                    <p class="text-xs text-gray-600">1-2 робочі дні</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl mb-2">✅</div>
                    <p class="text-sm font-semibold">Гарантія</p>
                    <p class="text-xs text-gray-600">12 місяців</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl mb-2">↩️</div>
                    <p class="text-sm font-semibold">Повернення</p>
                    <p class="text-xs text-gray-600">14 днів</p>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Опис</h2>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Specifications -->
            @if($product->specifications)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Характеристики</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($product->specifications as $spec => $value)
                            <div class="border-b py-2">
                                <p class="text-sm text-gray-600">{{ ucfirst($spec) }}</p>
                                <p class="font-semibold">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count())
        <section class="mt-16 pt-12 border-t">
            <h2 class="text-3xl font-bold mb-8">Схожі Товари</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @include('components.product-card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif

    <!-- Reviews Section -->
    <section id="reviews" class="mt-16 pt-12 border-t">
        <h2 class="text-3xl font-bold mb-8">Відгуки Покупців</h2>

        @if(auth()->check())
            <!-- Add Review Form -->
            <div class="bg-gray-100 p-6 rounded-lg mb-12">
                <h3 class="text-xl font-bold mb-4">Поділіться Вашою Думкою</h3>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-2">Оцінка *</label>
                        <div class="flex gap-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="mr-1">
                                    <span class="text-2xl">{{ str_repeat('⭐', $i) }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Ваш Відгук *</label>
                        <textarea name="review" placeholder="Что вам понравилось или не понравилось..." class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-2 rounded-lg transition">
                        Відправити Відгук
                    </button>
                </form>
            </div>
        @else
            <p class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-8">
                <a href="{{ route('login') }}" class="underline font-bold">Увійдіть</a>, щоб залишити відгук
            </p>
        @endif

        <!-- Reviews List -->
        <div class="space-y-6">
            @forelse($product->reviews()->latest()->paginate(5) as $review)
                <div class="border-b pb-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-bold">{{ $review->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $review->created_at->format('d.m.Y') }}</p>
                        </div>
                        <span class="text-lg">{{ str_repeat('⭐', $review->rating) }}</span>
                    </div>
                    <p class="text-gray-700">{{ $review->review }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Немає відгуків. Будьте першим!</p>
            @endforelse
        </div>
    </section>
@endsection
