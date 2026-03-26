<div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200 overflow-hidden">
    <!-- Image Container -->
    <div class="relative h-48 bg-gray-100 overflow-hidden group">
        <img src="{{ $product->image ?? 'https://via.placeholder.com/300x400?text=' . urlencode($product->name) }}" 
            alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition">
        
        <!-- Stock Badge -->
        @if ($product->stock_quantity > 5)
            <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs">В наявності</span>
        @elseif ($product->stock_quantity > 0)
            <span class="absolute top-2 right-2 bg-yellow-500 text-black px-2 py-1 rounded text-xs">{{ $product->stock_quantity }} шт</span>
        @else
            <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs">Немає</span>
        @endif

        <!-- Discount Badge -->
        @if ($product->cost && $product->price > $product->cost)
            <span class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">
                -{{ round(((($product->price - $product->cost) / $product->price) * 100)) }}%
            </span>
        @endif

        <!-- Wishlist Button -->
        @auth
            <button class="absolute bottom-2 right-2 bg-white bg-opacity-90 hover:bg-opacity-100 p-2 rounded-full transition
                {{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'text-red-500' : 'text-gray-400' }}">
                ❤️
            </button>
        @endauth
    </div>

    <!-- Content -->
    <div class="p-4">
        <!-- Category -->
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" 
            class="text-xs text-gray-500 hover:text-yellow-500">{{ $product->category->name }}</a>

        <!-- Title -->
        <h3 class="font-semibold text-gray-800 line-clamp-2 hover:text-yellow-500 cursor-pointer">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <!-- SKU -->
        <p class="text-xs text-gray-400 mb-2">SKU: {{ $product->sku }}</p>

        <!-- Rating -->
        <div class="flex items-center gap-1 mb-2">
            <span class="text-yellow-400">
                @for ($i = 0; $i < floor($product->rating); $i++)
                    ⭐
                @endfor
            </span>
            <span class="text-xs text-gray-500">({{ $product->review_count }} відгуків)</span>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <span class="text-xl font-bold text-red-600">₴{{ number_format($product->price, 0, ',', ' ') }}</span>
            @if ($product->cost && $product->price > $product->cost)
                <span class="text-sm text-gray-400 line-through ml-2">₴{{ number_format($product->cost * 1.5, 0, ',', ' ') }}</span>
            @endif
        </div>

        <!-- Buttons -->
        <div class="space-y-2">
            @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded transition @if($product->stock_quantity == 0) opacity-50 cursor-not-allowed @endif"
                        @if($product->stock_quantity == 0) disabled @endif>
                        🛒 У кошик
                    </button>
                </form>
            @else
                <a href="{{ route('login.show') }}" class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded transition">
                    🛒 У кошик
                </a>
            @endauth

            <a href="{{ route('products.show', $product->slug) }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded transition">
                👁️ Переглянути
            </a>
        </div>

        <!-- Shipping Info -->
        <p class="text-xs text-gray-500 mt-3 text-center">📦 Доставка: 1-2 робочих дні</p>
    </div>
</div>
