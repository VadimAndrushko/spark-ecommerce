@extends('layouts.app')

@section('title', 'Каталог | Spark')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Каталог Товарів</h1>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('home') }}" class="hover:text-yellow-500">Головна</a> / 
            <span>Каталог</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Filters -->
        <aside class="lg:col-span-1">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <!-- Clear Filters -->
                <a href="{{ route('products.index') }}" class="text-sm text-yellow-500 hover:underline">✕ Очистити фільтри</a>

                <!-- Search -->
                <div>
                    <label class="block font-semibold mb-2">Пошук</label>
                    <input type="text" name="search" placeholder="Знайти товар..." 
                        value="{{ request('search') }}" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <!-- Categories -->
                <div>
                    <label class="block font-semibold mb-2">Категорії</label>
                    <div class="space-y-2">
                        @foreach(App\Models\Category::where('is_active', true)->get() as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm">{{ $category->name }} ({{ $category->products_count ?? $category->products()->count() }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block font-semibold mb-2">Ціна (₴)</label>
                    <div class="flex gap-2">
                        <input type="number" name="price_min" placeholder="Від" 
                            value="{{ request('price_min') }}" class="w-full px-2 py-2 border rounded text-sm">
                        <input type="number" name="price_max" placeholder="До" 
                            value="{{ request('price_max') }}" class="w-full px-2 py-2 border rounded text-sm">
                    </div>
                </div>

                <!-- Brands -->
                <div>
                    <label class="block font-semibold mb-2">Бренди</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach(['Apple', 'Samsung', 'Sony', 'LG', 'Xiaomi', 'Google', 'OnePlus', 'Motorola'] as $brand)
                            <label class="flex items-center">
                                <input type="checkbox" name="brands[]" value="{{ $brand }}" 
                                    {{ in_array($brand, request('brands', [])) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm">{{ $brand }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Availability -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="in_stock" {{ request('in_stock') ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm font-semibold">Тільки в наявності</span>
                    </label>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block font-semibold mb-2">Рейтинг</label>
                    <div class="space-y-2">
                        @foreach([5, 4, 3, 2, 1] as $rating)
                            <label class="flex items-center">
                                <input type="radio" name="rating" value="{{ $rating }}" 
                                    {{ request('rating') == $rating ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm">
                                    @for($i = 0; $i < $rating; $i++) ⭐ @endfor
                                    ({{$rating}}+)
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded transition">
                    Застосувати Фільтри
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- View Toggle & Sorting -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex gap-2">
                    <button class="px-3 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600">⊞ Сітка</button>
                    <button class="px-3 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">☰ Список</button>
                </div>

                <select name="sort" onchange="window.location.href = '{{ route('products.index') }}?sort=' + this.value + '&{{ http_build_query(request()->except('sort')) }}'" 
                    class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Найновіші</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Популярні</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Ціна ↑</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Ціна ↓</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Рейтинг</option>
                </select>

                <span class="text-sm text-gray-600">
                    Товарів: {{ number_format($products->total() ?? 0) }}
                </span>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($products ?? [] as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg mb-4">Товари не знайдені 😞</p>
                        <a href="{{ route('products.index') }}" class="text-yellow-500 hover:underline">
                            Повернутись до каталогу
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products && $products->hasPages())
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
